<?php

namespace App\Http\Controllers\Funciones;

//require __DIR__ . "/vendor/autoload.php";

use App\Classes\MessageAlertClass;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\CentroLocalidad;
use App\User;
use Carbon\Carbon;
use Exception;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\NotWritableException;
use Intervention\Image\Facades\Image;
//use Intervention\Image\ImageManager;
use RapidApi\RapidApiConnect;

class FuncionesController extends Controller
{

    public function __construct(){}

    public static function setConfigOne(){
        ini_set('max_execution_time', 600);
        @ini_set( 'upload_max_size' , '32768M' );
        @ini_set( 'post_max_size', '32768M');
        @ini_set( 'max_execution_time', '256000000' );
        @ini_set('memory_limit', '-1');
        return true;
    }


    //
    public function toMayus($str=""){
        return strtr(strtoupper($str), "áéíóúñ", "ÁÉÍÓÚÑ");
    }

    public function showFile($root="/archivos/",$archivo=""){
        $public_path = public_path();
        $url = $public_path."/storage/".$root.$archivo;
        if (Storage::exists($archivo))
        {
            return response()->download($url);
        }
        abort(404);
    }

    public function str_sanitizer($filters){
//        $arr = array(' la ',' las ',' lo ',' los ',' de ',' del ',' fracc ',' col ',' col. ',' r/a ',' ria ',' ria. ',' conj ',' conj. ',' priv ',' priv. ',' av ',' av. ',' ave ',' ave. ',' carr ',' carr. ',' colonia ',' pob ',' pob. ',' cda ',' cda. ', 'méxico', 'tab.', 'tab,', 'villa ');
        $arr = array('c ',' la ',' lo ',' fracc ',' col ',' col. ',' r/a ',' ria ',' ria. ',' conj ',' conj. ',' priv ',' priv. ',' av ',' av. ',' ave ',' ave. ',' carr ',' carr. ',' colonia ',' pob ',' pob. ',' cda ',' cda. ', 'méxico', 'tab.', 'tab,', 'villa ');
        foreach($arr as $fil){
            $filters = str_replace($fil, ' ', $filters);
        }
        return $filters;
    }

    public function string_to_tsQuery(String $string, String $type){

        $string = str_replace(', ',' ', $string);
        $string = str_replace(',',' ', $string);

        $str = explode(' ',$string);
        //dd($str);
        $string = '';
        $i = 1;
        foreach ($str as $value){
            if ( strlen($value) >= 4 ){
                $vector = '';
                if ($string!=''){
                    $vector = $type;
                }
                if ( ! str_contains($string,$vector.$value) ){
//                if ( strpos($string, $vector.$value) == false)  {
                    $string = $string.$vector.$value;
                }
            }
            ++$i;
        }
        return $string;
    }

    // get IP, Host or IdEmp
    public function getIHE($type=0){
        switch ($type){
            case 0:
                return 1;
                break;
            case 1:
                return $_SERVER['REMOTE_ADDR'];
                break;
            case 2:
                return gethostbyaddr($_SERVER['REMOTE_ADDR']);
                break;
        }
    }

    public function setDateTo6Digit($fecha){
        if(is_null($fecha)){
            $fecha = Carbon::today()->toDateString();
        }
//        dd(Carbon::now());
        $fecha = str_replace('20','',$fecha);
        $fecha = str_replace('-','',$fecha);
        return $fecha;
    }

    public function getFechaFromNumeric($number){
        return
            '20'.substr($number,0,2).'-'.
            substr($number,2,2).'-'.
            substr($number,4,2)
            ;
    }

    public function fechaEspanol($f){
        $f = explode('-',substr($f,0,10));
        return $f[2].'-'.$f[1].'-'.$f[0];
    }

    public function fechaEspanolComplete($f,$type=false){
        $f = explode('-',substr($f,0,10));
        $f =  $f[2].'-'.$f[1].'-'.$f[0];
        return !$type ? $f.' 00:00:00' : $f.' 23:59:59';
    }

    public function fechaDateTimeFormat($f,$type=false){
        $f = explode('-',substr($f,0,10));
        $f = $f[0].'-'.$f[1].'-'.$f[2];
        return !$type ? $f.' 00:00:00' : $f.' 23:59:59';
    }

    public function getDatesFromMonthNow(){
        $f1 = Carbon::now()->format('Y-m').'-'.'01';
        $f2 = Carbon::now()->endOfMonth()->toDateString();
        return ["fecha_inicial" => $f1." 00:00:00", "fecha_final" => $f2." 23:59:59"];
    }


    public function validImage($model, $storage, $root, $type=1){
        $ext = config('atemun.images_type_extension');
//        for ($i=0;$i < count($ext);$i++){
        for ($i=0, $iMax = count($ext); $i < $iMax; $i++){
            $p1 = $model->id.'.'.$ext[$i];
            $p2 = '_'.$model->id.'.png';
            $p3 = '_thumb_'.$model->id.'.png';
            $e1 = Storage::disk($storage)->exists($p1);
            if ($e1) {
                switch ($type) {
                    case 1:
                        $model->update([
                            'root'              =>  $root,
                            'filename'          =>  $p1,
                            'filename_png'      =>  $p2,
                            'filename_thumb'    =>  $p3
                        ]);
                        break;
                }
            }
        }
    }

    public function deleteImages($model,$storage){
        $ext = ['jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG','xls','xlsx','doc','docx','ppt','pptx','txt','mp4','pages','key','numbers'];
        for ($i=0;$i<4;$i++){
            $p1 = $model->id.'.'.$ext[$i];
            $e1 = Storage::disk($storage)->exists($p1);
            if ($e1) {
                Storage::disk($storage)->delete($p1);
            }
        }
    }

    public function fitImage($imagePath, $filename, $W, $H, $IsRounded, $disk="profile", $profile_root="PROFILE_ROOT", $extension="png"){
        try{
            $image = Image::make($imagePath)->fit($W,$H);
            if ($IsRounded){
                $image->encode($extension);
                $width = $image->getWidth();
                $height = $image->getHeight();
                $mask = Image::canvas($width, $height);
                $mask->circle($width, $width/2, $height/2, function ($draw) {
                    $draw->background('#fff');
                });
                $image->mask($mask, false);
                $filePath = public_path(env($profile_root)).'/'.$filename;
                $image->save($filePath);
                Storage::disk($disk)->put($filename, $image);
                if (File::exists($filePath)) {
//                    unlink($filePath);
                }
            }else{
                $image = Storage::disk($disk)->put($filename, $image);
            }
        }catch (Exception $e){
            return "Error: " . $e->getMessage();
        }
        return $image;
    }




    public function deleteImageDropZone($image,$storage){
        $e1 = Storage::disk($storage)->exists($image);
        if ($e1) {
            Storage::disk($storage)->delete($image);
        }
    }

    public static function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip();
    }

    public static function remoteFileExists($url) {
        if (str_contains($url, "localhost")){
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_NOBODY, true);
            $result = curl_exec($curl);
            $ret = false;
            if ($result !== false) {
                $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($statusCode == 200) {
                    $ret = true;
                }
            }
            curl_close($curl);
            return $ret;
        }else{
            return file_get_contents($url,0,null,0,1);
        }
    }

    private function getRedirect(Request $request){
        $role1 = $request->user()->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE|USER_ARCHIVO_CAP|USER_ARCHIVO_ADMIN');
        $role2 = $request->user()->hasRole('CIUDADANO|DELEGADO');
        if ($role1) {
            return 'home';
        } elseif($role2) {
            return 'home-ciudadano';
        } else {
            return 'home';
        }
    }


    public static function itemSelectDenunciasV1(): array{
            return ['id','uuid','ciudadano','curp_ciudadano','ap_paterno_ciudadano','ap_materno_ciudadano','nombre_ciudadano',
                        'fecha_ingreso','dependencia_ultimo_estatus','area','subarea','servicio_ultimo_estatus','cp',
                        'celulares','telefonos','email','telefonoscelularesemails', 'calle','num_ext','num_int','colonia','ubicacion','ambito_dependencia',
                        'denuncia','referencia', 'status_denuncia','prioridad','origen','observaciones','genero_ciudadano',
                        'cerrado','origen_id','ciudadano_id','ultimo_estatus','firmado','latitud','longitud',
                        'clave_identificadora','estatus_general','ambito_sas','fecha_ultimo_estatus',
                        'creadopor_id','modificadopor_id','dias_ejecucion','dias_maximos_ejecucion',
                        'fecha_dias_ejecucion','fecha_dias_maximos_ejecucion','username',
                        'search_google','gd_ubicacion','prioridad_id','centro_localidad_id',
                        'ue_id'
                    ];
    }

    public static function itemSelectDenunciasV2(): array{
        return ['id','uuid','ciudadano','curp_ciudadano','ap_paterno_ciudadano','ap_materno_ciudadano','nombre_ciudadano',
            'fecha_ingreso','area','subarea','cp',
            'email','telefonoscelularesemails', 'calle','num_ext','num_int','colonia','ubicacion','ambito_dependencia',
            'descripcion as denuncia','referencia', 'status_denuncia','prioridad','origen','observaciones','genero_ciudadano',
            'cerrado','origen_id','ciudadano_id','firmado','latitud','longitud',
            'clave_identificadora','estatus_general','ambito_sas','fecha_ultimo_estatus',
            'creadopor_id','modificadopor_id','dias_ejecucion','dias_maximos_ejecucion',
            'fecha_dias_ejecucion','fecha_dias_maximos_ejecucion',
            'search_google','gd_ubicacion','prioridad_id','centro_localidad_id',
            'due_id','sue_id','ue_id'
        ];
    }

    public static function itemSelectDenuncias(): array{
        return ['id','ciudadano_id','dependencia_id','origen_id','prioridad_id','creadopor_id','ubicacion_id',
            'fecha_ingreso', 'latitud','longitud','gd_ubicacion','search_google','ambito','codigo_postal_manual',
            'descripcion','search_google_select','centro_colonia','centro_delegacion',
            'uuid','cerrado','firmado',
            'ue_id','due_id','sue_id','fecha_ultimo_estatus',
            'centro_localidad_id',
            'dias_atendida','dias_rechazada','dias_observada',
            'servicio_id','estatu_id','fecha_movimiento','telefonoscelularesemails',
            'servicio','estatus','ubicacion_id','ciudadano','curp_ciudadano','dependencia',
            'ambito_dependencia','observaciones','medida_id',
        ];
    }

    public static function arrAmbitosViejitos(): array{
        return [1,99];
    }

    public static function arrAmbitosApoyosSociales(): array{
        return [1,99];
    }

    public static function arrAmbitosServiciosMunicipales(): array{
        return [2];
    }

    public static function arrAmbitosDependencia(): array{
        return [1=>"Apoyos Sociales",2=>"Servicios Municipales",99=>"SM Viejitos"];
    }

    public static function arrAmbitosSM(): array{
        return [0=>"No Aplica",1=>"Urbana",2=>"Rural",3=>"Desazolve Manual",4=>"Desazolve con Vactor",5=>"Desazolve con equipo almeja"];
    }

    public static function GetCapturistasAmbito2P(): Collection{

        $IsEnlace               = Auth::user()->isRole('ENLACE');
//        $IsAdminArchivo         = Auth::user()->isRole('USER_ARCHIVO_ADMIN');
        $IsDelegados            = Auth::user()->isRole('DELEGADOS');
        $IsCoordinadorDelegados = Auth::user()->isRole('COORDINACION_DE_DELEGADOS');

        // full_name_with_username_dependencia

        if ($IsEnlace) {
            return User::query()
                ->where("status_user", 1)
                ->whereHas('roles', function ($q) {
                    return $q->whereIn('name',array('ENLACE','USER_OPERATOR_SIAC','USER_OPERATOR_ADMIN') );
                })
                ->get()
                ->sortBy('full_name')
                ->pluck('full_name','id');
        }

        if ($IsDelegados) {
            return User::query()
                ->where("id", Auth::user()->id)
                ->where("status_user", 1)
                ->get()
                ->sortBy('full_name')
                ->pluck('full_name','id');
        }

        if ($IsCoordinadorDelegados) {
            return User::query()
                ->where("status_user", 1)
                ->whereHas('roles', function ($q) {
                    return $q->whereIn('name',array('DELEGADOS','COORDINACION_DE_DELEGADOS') );
                })
                ->get()
                ->sortBy('full_name')
                ->pluck('full_name','id');
        }

        return User::query()
            ->where("status_user", 1)
            ->whereHas('roles', function ($q) {
                return $q->whereIn('name',array('ENLACE','USER_OPERATOR_SIAC','USER_OPERATOR_ADMIN','DELEGADOS','COORDINACION_DE_DELEGADOS') );
            })
            ->get()
            ->sortBy('full_name')
            ->pluck('full_name','id');

    }


    public static function menuDashBoard($activo): array{

//        $arrLegenMenu = ["Inicio","General","Alumbrado","Espacios Públicos","Limpia","Obras","SAS","Encuestas","Reportes"];
        $arrLegenMenu = ["Inicio","General","Alumbrado","Espacios Públicos","Limpia","Obras","SAS"];
        $arrUrls = array(
            "/dashboard-statistics-servicios-principales",
            "/dashboard-statistics-general",
            "/dashboard-statistics-custom-unity/46",
            "/dashboard-statistics-custom-unity/49",
            "/dashboard-statistics-custom-unity/50",
            "/dashboard-statistics-custom-unity/48",
            "/dashboard-statistics-custom-unity/47",
        );
//        "/dashboard-statistics-encuestas",
//            "/dashboard-statistics-reportes",

        $menu = [];
        for ($i = 0; $i < 7; $i++) {
            $menu[] = (object)["url" => $arrUrls[$i], "clase" => $i === $activo ? "menu-item active" : "menu-item", "title_menu" => $arrLegenMenu[$i], "index" => $i];
        }

        return $menu;
    }

    public static function loQueSeModifico($item_viejito,$item_nuevo):array {
        $item_nuevo = (object) $item_nuevo;

        $campos_modificados = '';
        $antes = '';
        $despues = '';
        if ( $item_viejito !== null ) {

            if ($item_nuevo->descripcion !== $item_viejito->descripcion) {
                $campos_modificados .= 'descripción, ';
                $antes .= $item_viejito->descripcion . ',';
                $despues .= $item_nuevo->descripcion . ',';
            }

            if ($item_nuevo->referencia !== $item_viejito->referencia) {
                $campos_modificados .= 'referencia, ';
                $antes .= $item_viejito->referencia . ',';
                $despues .= $item_nuevo->referencia . ',';
            }

            if ($item_nuevo->latitud !== $item_viejito->latitud) {
                $campos_modificados .= 'latitud, ';
                $antes .= $item_viejito->latitud . ',';
                $despues .= $item_nuevo->latitud . ',';
            }

            if ($item_nuevo->longitud !== $item_viejito->longitud) {
                $campos_modificados .= 'longitud, ';
                $antes .= $item_viejito->longitud . ',';
                $despues .= $item_nuevo->longitud . ',';
            }

            if ($item_nuevo->search_google !== $item_viejito->search_google) {
                $campos_modificados .= 'búsqueda_google, ';
                $antes .= $item_viejito->search_google . ',';
                $despues .= $item_nuevo->search_google . ',';
            }

            if ($item_nuevo->gd_ubicacion !== $item_viejito->gd_ubicacion) {
                $campos_modificados .= 'google_ubicación, ';
                $antes .= $item_viejito->gd_ubicacion . ',';
                $despues .= $item_nuevo->gd_ubicacion . ',';
            }

            if ($item_nuevo->codigo_postal_manual !== $item_viejito->codigo_postal_manual) {
                $campos_modificados .= 'codigo_postal_manual, ';
                $antes .= $item_viejito->codigo_postal_manual . ',';
                $despues .= $item_nuevo->codigo_postal_manual . ',';
            }

            if ($item_nuevo->search_google_select !== $item_viejito->search_google_select) {
                $campos_modificados .= 'search_google_select, ';
                $antes .= $item_viejito->search_google_select . ',';
                $despues .= $item_nuevo->search_google_select . ',';
            }

            if ((int) $item_nuevo->prioridad_id !== (int) $item_viejito->prioridad_id) {
                $campos_modificados .= 'prioridad_id, ';
                $antes .= (int) $item_viejito->prioridad_id . ',';
                $despues .= (int) $item_nuevo->prioridad_id . ',';
            }
            if ((int) $item_nuevo->prioridad_id !== (int) $item_viejito->prioridad_id) {
                $campos_modificados .= 'prioridad, ';
                $antes .= $item_viejito->prioridad->prioridad . ',';
                $despues .= $item_nuevo->prioridad->prioridad . ',';
            }
            if ((int) $item_nuevo->origen_id !== (int) $item_viejito->origen_id) {
                $campos_modificados .= 'origen_id, ';
                $antes .= (int) $item_viejito->origen_id . ',';
                $despues .= (int) $item_nuevo->origen_id . ',';
            }
            if ((int) $item_nuevo->origen_id !== (int) $item_viejito->origen_id) {
                $campos_modificados .= 'origen, ';
                $antes .= $item_viejito->origen->origen . ',';
                $despues .= $item_nuevo->origen->origen . ',';
            }
            if ((int) $item_nuevo->dependencia_id !== (int) $item_viejito->dependencia_id) {
                $campos_modificados .= 'dependencia_id, ';
                $antes .= (int) $item_viejito->dependencia_id . ',';
                $despues .= (int) $item_nuevo->dependencia_id . ',';
            }
            if ((int) $item_nuevo->dependencia_id !== (int) $item_viejito->dependencia_id) {
                $campos_modificados .= 'dependencia, ';
                $antes .= $item_viejito->dependencia->dependencia . ',';
                $despues .= $item_nuevo->dependencia->dependencia . ',';
            }
            if ((int) $item_nuevo->servicio_id !== (int) $item_viejito->servicio_id) {
                $campos_modificados .= 'servicio_id, ';
                $antes .= (int) $item_viejito->servicio_id . ',';
                $despues .= (int) $item_nuevo->servicio_id . ',';
            }
            if ((int) $item_nuevo->servicio_id !== (int) $item_viejito->servicio_id) {
                $campos_modificados .= 'servicio, ';
                $antes .= $item_viejito->servicio->servicio . ',';
                $despues .= $item_nuevo->servicio->servicio . ',';
            }

            if ((int) $item_nuevo->ambito !== (int) $item_viejito->ambito) {
                $campos_modificados .= 'ámbito, ';
                $antes .= self::arrAmbitosSM()[$item_viejito->ambito] . ',';
                $despues .= self::arrAmbitosSM()[$item_viejito->ambito] . ',';
            }

            if ((int) $item_nuevo->centro_localidad_id !== (int) $item_viejito->centro_localidad_id) {
                $campos_modificados .= 'centro_localidad_id, ';
                $antes .= (int) $item_viejito->centro_localidad_id . ',';
                $despues .= (int) $item_nuevo->centro_localidad_id . ',';
            }

            if ( (int) $item_nuevo->centro_localidad_id !== (int) $item_viejito->centro_localidad_id) {
                $locViejita = CentroLocalidad::find((int) $item_viejito->centro_localidad_id);
                $locNuevo = CentroLocalidad::find((int) $item_nuevo->centro_localidad_id);
                $campos_modificados .= 'centro_localidad, ';
                $antes .= $locViejita->ItemColoniaDelegacion() . ',';
                $despues .= $locNuevo->ItemColoniaDelegacion() . ',';
            }

        }

        return ['campos_modificados' => $campos_modificados,'antes' => $despues,'despues' => $antes];

    }

    public static function obtenerDiasInicioFinMeses() {
        $meses = [];
        for ($m=1; $m<=12; $m++) {
            $fechaInicio = Carbon::create(null, $m, 1);
            $fechaFin = $fechaInicio->copy()->endOfMonth();
            $meses[$m] = [
                'nombre_mes' => $fechaInicio->locale('es')->monthName,
                'inicio' => $fechaInicio->format('Y-m-d'),
                'fin' => $fechaFin->format('Y-m-d'),
            ];
        }
        return $meses;
    }



}
