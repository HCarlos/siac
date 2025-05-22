<?php

namespace App\Http\Controllers\Denuncia;

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Classes\FiltersRules;
use App\Classes\FiltersRulesBySearch;
use App\Events\IUQDenunciaEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Requests\Denuncia\DenunciaRequest;
use App\Http\Requests\Denuncia\SearchIdenticalAmbitoRequest;
use App\Http\Requests\Denuncia\SearchIdenticalRequest;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Origen;
use App\Models\Catalogos\Prioridad;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use App\Models\Denuncias\Firma;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\isEmpty;


class DenunciaController extends Controller{

    protected $tableName = "solicitudes";
    protected $paginationTheme = 'bootstrap';
    protected $msg = "";
    protected $max_item_for_query = 150;

    // ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //

    /**
     * @param string $tableName
     */

    public function __construct(){
        $this->middleware('auth');
    }

    protected function index(Request $request){

        ini_set('max_execution_time', 300);
        session::forget('ambito_dependencia');

        $search = $request->only(['search']);

        $filters['filterdata'] = $search;
        session(['is_pagination' => true]);


        if ( $search !== [] && isEmpty($search) !== null && $search !== "" ) {
            $items = _viDDSs::query()
                ->select(FuncionesController::itemSelectDenunciasV1())
                ->GetDenunciasItemCustomFilter($filters)
                ->orderByDesc('id')
                ->get();
            session(['is_pagination' => false]);
        }else{
            $items = _viDDSs::query()
                ->select(FuncionesController::itemSelectDenunciasV1())
                ->GetDenunciasItemCustomFilter($filters)
                ->orderByDesc('id')
                ->paginate($this->max_item_for_query);
            $items->appends($search)->fragment('table');
        }

        $request->session()->put('items', $items);


        session(['msg' => '']);

        $user = Auth::User();

        return view('SIAC.denuncia.denuncia.denuncia_list',
            [
                'items'                               => $items,
                'titulo_catalogo'                     => "Catálogo de " . ucwords($this->tableName),
                'user'                                => $user,
                'searchInListDenuncia'                => 'listDenuncias',
                'newWindow'                           => true,
                'tableName'                           => $this->tableName,
                'showEdit'                            => 'editDenuncia',
                'showAddUser'                         => 'addUserDenuncia',
                'showEditDenunciaDependenciaServicio' => 'listDenunciaDependenciaServicio',
                'showProcess1'                        => 'showDataListDenunciaExcel1A',
                'newItem'                             => 'newDenuncia',
                'removeItem'                          => 'removeDenuncia',
                'respuestasDenunciaItem'              => 'listRespuestas',
                'respuestasDenunciaCiudadanaItem'     => 'listRespuestasCiudadanas',
                'imagenesDenunciaItem'                => 'listImagenes',
                'searchAdressDenuncia'                => 'listDenuncias',
                'showModalSearchDenuncia'             => 'showModalSearchDenuncia',
                'findDataInDenuncia'                  => 'findDataInDenuncia',
                'imprimirDenuncia'                    => "imprimir_denuncia_archivo/",
                'IsEnlace'                            => session('IsEnlace'),
                'DependenciaArray'                    => session('DependenciaArray'),
                'is_pagination'                       => session('is_pagination'),
            ]
        );
    }

    protected function newItem(){
        $Prioridades  = Prioridad::query()
                            ->where("estatus_cve", 1)
                            ->orderBy('prioridad')
                            ->get();

        $Origenes     = Origen::query()
                            ->where("estatus_cve", 1)
                            ->orderBy('origen')
                            ->get();

        $IsEnlace = Session::get('IsEnlace');
        if($IsEnlace){
            $DependenciaIdArray = Session::get('DependenciaIdArray');

            $Dependencias = Dependencia::query()
                ->where("estatus_cve", 1)
                ->whereIn("ambito_dependencia", FuncionesController::arrAmbitosViejitos())
                ->whereIn('id',$DependenciaIdArray)
                ->orderBy('dependencia')
                ->get();

            //dd($Dependencias);

        }else{
            $Dependencias = Dependencia::query()
                ->whereIn("ambito_dependencia", FuncionesController::arrAmbitosViejitos())
                ->where("estatus_cve", 1)
                ->orderBy('dependencia')
                ->get();
        }

        if (Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN') ) {
            $Estatus = Estatu::query()
                        ->where("estatus_cve", 1)
                        ->where('ambito_estatus', 99)
                        ->orderBy('estatus')
                        ->get();
        }else{
            $Estatus = Estatu::query()
                ->where('estatus_cve',1)
                ->where('ambito_estatus', 99)
                ->orderBy('estatus')
                ->get();
        }

        $hashtag = Denuncia::select('clave_identificadora')
                    ->where("status_denuncia", 1)
                    ->distinct('clave_identificadora')
                    ->orderBy('clave_identificadora')
                    ->pluck('clave_identificadora','clave_identificadora');

        $this->msg = "";
        return view('SIAC.denuncia.denuncia.denuncia_new',
            [
                'user'            => Auth::user(),
                'editItemTitle'   => 'Nuevo',
                'prioridades'     => $Prioridades,
                'origenes'        => $Origenes,
                'dependencias'    => $Dependencias,
                'estatus'         => $Estatus,
                'hashtag'        => $hashtag,
                'postNew'         => 'createDenuncia',
                'titulo_catalogo' => ucwords($this->tableName),
                'titulo_header'   => 'Folio Nuevo',
                'exportModel'     => 23,
                'msg'             => $this->msg,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function createItem(DenunciaRequest $request){
        $item = $request->manage();
        if (!isset($item->id)) {
            abort(422);
        }
        $this->msg = "Registro Guardado con éxito!";
        session(['msg' => $this->msg]);
        return Redirect::to('editDenuncia/'.$item->id);

    }



    protected function editItem($Id){

        $item         = Denuncia::find($Id);

        $Prioridades  = Prioridad::query()
                            ->where("estatus_cve", 1)
                            ->orderBy('prioridad')
                            ->get();

        $Origenes     = Origen::query()
                            ->where("estatus_cve", 1)
                            ->orderBy('origen')
                            ->get();

        $IsEnlace = Session::get('IsEnlace');
        if($IsEnlace){
//            $DependenciaIdArray = explode('|',Session::get('DependenciaIdArray'));
            $DependenciaIdArray = Session::get('DependenciaIdArray');
            $Dependencias = Dependencia::query()
                ->where("estatus_cve", 1)
                ->whereIn("ambito_dependencia", FuncionesController::arrAmbitosViejitos())
                ->whereIn('id',$DependenciaIdArray)
                ->orderBy('dependencia')
                ->get();

        }else{
            $Dependencias = Dependencia::query()
                ->where("estatus_cve", 1)
                ->whereIn("ambito_dependencia", FuncionesController::arrAmbitosViejitos())
                ->orderBy('dependencia')
                ->get();
        }

        $Servicios = Servicio::getQueryServiciosFromDependencias($item->dependencia_id,1);

        $user_ubicacion = $item->Ciudadano->ubicaciones->first->id->id;

        if ( $user_ubicacion == $item->ubicacion_id ){
            $pregunta1 = 0;
        }else{
            $pregunta1 = 1;
        }

        if (Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN') ) {

            $Estatus = Estatu::query()
                        ->where("estatus_cve", 1)
                        ->where('ambito_estatus', 99)
                        ->orderBy('estatus')
                        ->get();
        }else{

            $Estatus = Estatu::query()
                        ->where('estatus_cve',1)
                        ->where('ambito_estatus', 99)
                        ->orderBy('estatus')
                        ->get();

        }

        $hashtag = Denuncia::select('clave_identificadora')
                    ->where("status_denuncia", 1)
                    ->distinct('clave_identificadora')
                    ->orderBy('clave_identificadora')
                    ->pluck('clave_identificadora','clave_identificadora');

        $this->msg = "";
        return view('SIAC.denuncia.denuncia.denuncia_edit',
            [
                'user'            => Auth::user(),
                'prioridades'     => $Prioridades,
                'origenes'        => $Origenes,
                'dependencias'    => $Dependencias,
                'servicios'       => $Servicios,
                'estatus'         => $Estatus,
                'hashtag'         => $hashtag,
                'items'           => $item,
                'editItemTitle'   => isset($item->denuncia) ? $item->denuncia : 'Nuevo',
                'putEdit'         => 'updateDenuncia',
                'removeItem'      => 'removeImagene',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio: '.$Id,
                'msg'             => $this->msg,
                'pregunta1'       => $pregunta1,
            ]
        );
    }

// ***************** GUARDA LOS CAMBIOS ++++++++++++++++++++ //
    protected function updateItem(DenunciaRequest $request){

        $item = $request->manage();
//        dd($item);
        if (!isset($item->id)) {
            abort(422);
//            dd($item);
        }
        $this->msg = "Registro Guardado con éxito!";
        session(['msg' => $this->msg]);
        return Redirect::to('editDenuncia/'.$item->id);
    }

// ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //

    protected function remove($id = 0){
        $trigger_type = 2;
        $item = Denuncia::withTrashed()->findOrFail($id);
        if (isset($item)) {
            if (!$item->trashed()) {
                $item->forceDelete();
            } else {
                $item->forceDelete();
            }
            event(new IUQDenunciaEvent($item->id,Auth::user()->id,$trigger_type));
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        } else {
            return Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
        }
    }

    protected function removeItem($id = 0){
        $item = Denuncia::withTrashed()->findOrFail($id);
        if (Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|USER_SAS_ADMIN|USER_DIF_ADMIN')){
            return $this->remove($id);
        }elseif ( Auth::user()->isRole('ENLACE') && Auth::user()->id == $item->creadopor_id ){
            return $this->remove($id);
        }else{
            return Response::json(['mensaje' => 'Acceso Denegado', 'data' => 'Error', 'status' => '200'], 200);
        }

    }

// ***************** MAUTOCOMPLETE DE UBICACIONES ++++++++++++++++++++ //
    protected function searchAdress(Request $request)
    {
        ini_set('max_execution_time', 300000);
        $filters =$request->input('search');
        $F           = new FuncionesController();

//        $tsString    = $F->string_to_tsQuery( strtoupper($filters),' & ');
        $filters      = strtolower($filters);
        $filters      = $F->str_sanitizer($filters);
        $tsString     = $F->string_to_tsQuery( strtoupper($filters),' & ');

        $items = Ubicacion::query()
            ->search($tsString)
            ->orderBy('id')
            ->get();

        $data=array();

        foreach ($items as $item) {
            $data[]=array('value'=>$item->calle.' '.$item->num_ext.' '.$item->num_int.' '.$item->colonia.' '.$item->comunidad,' '.$item->ciudad,'id'=>$item->id);
        }
        if(count($data))
            return $data;
        else
            return ['value'=>'No se encontraron resultados','id'=>0];
//        return Response::json(['mensaje' => 'OK', 'data' => json_decode($data), 'status' => '200'], 200);

    }

// ***************** MAUTOCOMPLETE DE UBICACIONES ++++++++++++++++++++ //
    protected function getUbi($IdUbi=0){

        $F = new FuncionesController();
        $item = Ubicacion::find($IdUbi);
        $sl = strtolower($item->calle.' '.$item->num_ext.' '.$item->num_int.' '.$item->colonia.' '.$item->municipio);
        $sl = $F->str_sanitizer($sl);
        $item->sanitizer_location = $sl;

        return Response::json(['mensaje' => 'OK', 'data' => json_decode($item), 'status' => '200'], 200);

    }

    protected function showModalSearchDenuncia(){

        if (Auth::user()->isRole('ENLACE')){

            $DependenciaIdArray = Auth::user()->DependenciaIdArray;
            $dependencia_id_array = $DependenciaIdArray;

            $Dependencias = Dependencia::query()
                ->where("estatus_cve", 1)
                ->whereIn("ambito_dependencia", FuncionesController::arrAmbitosViejitos())
                ->whereIn('id',$dependencia_id_array)
                ->orderBy('dependencia')
                ->pluck('dependencia','id');

            $dep_id = $dependencia_id_array[0];
//            $Servicios = Servicio::where("estatus_cve", 1)
//                            ->whereHas('subareas', function($p) use ($dep_id) {
//                                $p->whereHas("areas", function($q) use ($dep_id){
//                                    return $q->where("dependencia_id",$dep_id);
//                                });
//                            })->orderBy('servicio')
//                            ->get()
//                            ->pluck('servicio','id');

        }else{
            $Dependencias = Dependencia::query()
                                ->where("estatus_cve", 1)
                                ->whereIn("ambito_dependencia", FuncionesController::arrAmbitosViejitos())
                                ->orderBy('dependencia')
                                ->pluck('dependencia','id');
//            $Servicios    = Servicio::query()
//                                ->where("estatus_cve", 1)
//                                ->orderBy('servicio')
//                                ->pluck('servicio','id');
        }

        if(Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN')){
            $Estatus = Estatu::query()
                        ->where("estatus_cve", 1)
                        ->where('ambito_estatus', 99)
                        ->orderBy('estatus')
                        ->get();
        }else{
            $Estatus = Estatu::query()
                        ->where("estatus_cve", 1)
                        ->where('ambito_estatus', 99)
                        ->orderBy('estatus')
                        ->get();
        }

        $Origenes = Origen::query()
                        ->where("estatus_cve", 1)
                        ->orderBy('origen')
                        ->get();

        $Capturistas = User::query()->whereHas('roles', function ($q) {
                            return $q->whereIn('name',array('ENLACE','USER_OPERATOR_SIAC','USER_OPERATOR_ADMIN') );
                        })
                        ->get()
                        ->sortBy('full_name_with_username_dependencia')
                        ->pluck('full_name_with_username_dependencia','id');

        $hashtag = Denuncia::select('clave_identificadora')
                    ->where("status_denuncia", 1)
                    ->distinct('clave_identificadora')
                    ->orderBy('clave_identificadora')
                    ->pluck('clave_identificadora','clave_identificadora');

        $user = Auth::user();
        return view ('SIAC.denuncia.search.denuncia_search_panel',
            [
                'findDataInDenuncia' => 'findDataInDenuncia',
                'dependencias'       => $Dependencias,
                'capturistas'        => $Capturistas,
                'servicios'          => [], //$Servicios,
                'estatus'            => $Estatus,
                'origenes'           => $Origenes,
                'hashtag'            => $hashtag,
                'items'              => $user,
            ]
        );
    }


 // ***************** MUESTRA EL MENU DE BUSQUEDA ++++++++++++++++++++ //
    protected function findDataInDenuncia(Request $request){
        $filters = new FiltersRules();

        $queryFilters = $filters->filterRulesDenuncia($request);

        $req = $request->only(['items_for_query']);
        if ( isset($req['items_for_query'])){
            $this->max_item_for_query = $req['items_for_query'];
            session(['items_for_query' => $this->max_item_for_query]);
        }else{
            $this->max_item_for_query = session::get('items_for_query');
        }

        $items = _viDDSs::query()->select(FuncionesController::itemSelectDenunciasV1())
            ->filterBy($queryFilters)
            ->orderByDesc('id')
            ->paginate($this->max_item_for_query);
        $items->appends($queryFilters)->fragment('table');

        $user = Auth::User();

        $request->session()->put('items', $items);

        return view('SIAC.denuncia.denuncia.denuncia_list',
            [
                'items'                               => $items,
                'titulo_catalogo'                     => "Catálogo de " . ucwords($this->tableName),
                'user'                                => $user,
                'searchInListDenuncia'                => 'listDenuncias',
                'respuestasDenunciaItem'              => 'listRespuestas',
                'respuestasDenunciaCiudadanaItem'     => 'listRespuestasCiudadanas',
                'newWindow'                           => true,
                'tableName'                           => $this->tableName,
                'showEdit'                            => 'editDenuncia',
                'showAddUser'                         => 'addUserDenuncia',
                'newItem'                             => 'newDenuncia',
                'removeItem'                          => 'removeDenuncia',
                'showProcess1'                        => 'showDataListDenunciaExcel1A',
                'searchAdressDenuncia'                => 'listDenuncias',
                'showModalSearchDenuncia'             => 'showModalSearchDenuncia',
                'findDataInDenuncia'                  => 'findDataInDenuncia',
                'showEditDenunciaDependenciaServicio' => 'listDenunciaDependenciaServicio',
                'imagenesDenunciaItem'                => 'listImagenes',
                'is_pagination'                       => true,
            ]
        );

    }

// ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
    protected function getServiciosFromDependencias($id= 0, $efect){

        $item = Servicio::getQueryServiciosFromDependencias($id,$efect);

        if (isset($item)) {
            return Response::json(['mensaje' => 'OK', 'data' => $item, 'status' => '200'], 200);
        } else {
            return Response::json(['mensaje' => 'Error', 'data' => $item, 'status' => '200'], 200);
        }

    }

    protected function closeItem($id){
        $item    = Denuncia::find($id);
        $estatus = Estatu::query()
                    ->where("estatus_cve", 1)
                    ->where('estatus','CERRADO')
                    ->first();
        if (isset($item)) {
            $item->estatus_id = $estatus->id;
            $item->cerrado = true;
            $item->fecha_cerrado = now();
            $item->cerradopor_id = Auth::user()->id;
            $item->save();

            $item->estatus()->attach($estatus);
            $item->dependencias()->attach($item->dependencia_id,['servicio_id'=>$item->servicio_id,'estatu_id'=>$estatus->id,'fecha_movimiento' => now(),'observaciones' => 'CERRADO CON ÉXITO!' ]);

            return Response::json(['mensaje' => 'Documento cerrado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        } else {
            return Response::json(['mensaje' => 'No se pudo cerrar el documento.', 'data' => 'Error', 'status' => '200'], 200);
        }

    }

    protected function signItem($id){
        $den    = Denuncia::find($id);
        if (isset($den)) {

            $FOLIO = "DAC-".str_pad($id,6,'0',STR_PAD_LEFT)."-".$den->fecha_ingreso->format('y');
            $timex  = $den->fecha_ingreso->format('d-m-Y H:i:s');

            $archivo_cer = "hirc711126jt0.pem";
            $archivo_key = "Claveprivada_FIEL_HIRC711126JT0_20211206_140329.pem";
            $mensaje     = public_path() . "/signature/mensaje.txt";
            $firmado     = public_path() . "/signature/firmado.txt";
            $pem         = public_path() . "/signature/".$archivo_cer;
            $key_pem     = public_path() . "/signature/".$archivo_key;
            $phrase      = 'NxsWry2K_';
            $fp          = fopen(public_path() . "/signature/mensaje.txt", "w");

            $cadena_original = $den->id . '|' . $FOLIO . '|' . $timex . '|' . $den->ciudadano->id . '|' . $den->ciudadano->username . '|' . $den->ciudadano->FullName . '|' . $den->creadopor->id . '|' . $den->creadopor->username . '|' . $den->creadopor->FullName . '|' . $den->dependencia_id . '|' . $den->ubicacion_id . '|' . $den->servicio_id . '|' . $den->estatus_id;
            $hash = sha1($cadena_original);

            fwrite($fp, $hash);
            fclose($fp);

            $key = $key_pem;
            $fp = fopen($key, "r");
            $priv_key = fread($fp, 8192);

            $pkeyid = openssl_get_privatekey($priv_key);

            if (openssl_sign($mensaje, $firmado, $pkeyid, OPENSSL_ALGO_SHA1)) {
                $sello = base64_encode($firmado);
            }

            $firma = Firma::create([
                'archivo_cer'     => $archivo_cer,
                'sello_cer'       => $pem,
                'archivo_key'     => $archivo_key,
                'sello_key'       => $key_pem,
                'password'        => $phrase,
                'cadena_original' => $cadena_original,
                'hash'            => $hash,
                'sello'           => $sello,
                'valido'          => true,
                'fecha_firmado'   => now(),
                'firmadopor_id'   => Auth::user()->id,
            ]);
            $den->firmado = true;
            $den->save();
            $den->firmas()->attach($firma);

            return Response::json(['mensaje' => 'Documento firmado con éxito', 'data' => 'OK', 'status' => '200'], 200);

        }

    }


    protected function addUserItem($Id){

        $item         = Denuncia::find($Id);

        $this->msg = "";
        return view('SIAC.denuncia.denuncia.denuncia_add_user',
            [
                'user'            => Auth::user(),
                'items'           => $item,
                'putAddUserEdit'  => 'updateAddUserDenuncia',
                'removeItem'      => 'removeAddUserDenuncia',
                'titulo_catalogo' => "Agregando usuario al folio " .$Id,
                'titulo_header'   => "Agregando usuario al folio " .$Id,
                'msg'             => $this->msg,
            ]
        );
    }

// ***************** GUARDA LOS CAMBIOS ++++++++++++++++++++ //

    protected function updateAddUserDenunciaGet($id,$usuario_id){
        return $this->addUserToDemanda($id, $usuario_id);
    }

    protected function updateAddUserDenuncia(Request $request){

        return $this->addUserToDemanda($request['id'], $request['usuario_id']);
    }

    private function addUserToDemanda($id, $usuario_id){
        $item = Denuncia::find($id);
        if ($item->cerrado == false && (int) $usuario_id !== 0) {
            $item->ciudadanos()->detach($usuario_id);
            $item->ciudadanos()->attach($usuario_id);
        }
//        return Redirect::back();
        return \redirect()->route('addUserDenunciaAmbito', ['Id' => $id]);
    }


    protected function searchIdentical(SearchIdenticalAmbitoRequest $request){
        $items = $request->manage();
//        dd($items);
        if ($items === null || $items === []) {
            return Response::json(['mensaje' => 'No hay datos', 'result_msg' => 'Error', 'data' => null, 'status' => '200'], 200);
        }
        return Response::json(['mensaje' => count($items).' registros(s).', 'result_msg' => 'OK', 'data' => $items, 'status' => '200'], 200);
    }


    protected function removeAddUserDenuncia($id0 = 0, $id1 = 0){

        $item = Denuncia::find($id0);
        $item->ciudadanos()->detach($id1);
        return Response::json(['mensaje' => 'Eliminado', 'data' => 'OK', 'status' => '200'], 200);

    }

    public function vistaDenuncia($denuncia_id){
        $viDen = new VistaDenunciaClass();
        $viDen->vistaDenuncia($denuncia_id);
        return \redirect()->route('listDenuncias');
    }



}
