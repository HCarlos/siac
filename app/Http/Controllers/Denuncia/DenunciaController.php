<?php

namespace App\Http\Controllers\Denuncia;

use App\Classes\FiltersRules;
use App\Classes\Items;
use App\Events\IUQDenunciaEvent;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Requests\Denuncia\SearchIdenticalRequest;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Origen;
use App\Models\Catalogos\Prioridad;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use App\Models\Denuncias\Firma;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Denuncia\DenunciaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use function React\Promise\all;


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

    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);

//        if ( Auth::user()->can('consulta_500_items_general') ){
//            $this->max_item_for_query = config("atemun.consulta_500_items_general");
//        }

        $search = $request->only(['search']);

        $filters['filterdata'] = $request->only(['search']);
         //dd( $filter );
        $items = Denuncia::query()
            ->getDenunciasItemCustomFilter($filters)
            ->orderByDesc('id')
            ->paginate($this->max_item_for_query);
        $items->appends($filters)->fragment('table');

        // dd($items);

        $request->session()->put('items', $items);

        session(['msg' => '']);

        $user = Auth::User();

        return view('SIAC.denuncia.denuncia.denuncia_list',
            [
                'items'                               => $items,
                'titulo_catalogo'                     => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'                       => "Catálogo de " . ucwords($this->tableName),
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
            ]
        );
    }

    protected function newItem(){
        $Prioridades  = Prioridad::all()->sortBy('prioridad');
        $Origenes     = Origen::all()->sortBy('origen');

        $IsEnlace = Session::get('IsEnlace');
        if($IsEnlace){
//            $DependenciaIdArray = explode('|',Session::get('DependenciaIdArray'));
            $DependenciaIdArray = Session::get('DependenciaIdArray');
            //dd($DependenciaArray);
            $Dependencias = Dependencia::all()->whereIn('id',$DependenciaIdArray,false)->sortBy('dependencia');
            //dd($Dependencias);

        }else{
            $Dependencias = Dependencia::all()->sortBy('dependencia');
        }

        if (Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN') ) {
            $Estatus      = Estatu::all()->sortBy('estatus');
        }else{
            $Estatus      = Estatu::all()->where('estatus_cve',1)->sortBy('estatus');
        }

        $hashtag = Denuncia::select('clave_identificadora')->distinct('clave_identificadora')->orderBy('clave_identificadora')->pluck('clave_identificadora','clave_identificadora');

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
        $Prioridades  = Prioridad::all()->sortBy('prioridad');
        $Origenes     = Origen::all()->sortBy('origen');

        $IsEnlace = Session::get('IsEnlace');
        if($IsEnlace){
//            $DependenciaIdArray = explode('|',Session::get('DependenciaIdArray'));
            $DependenciaIdArray = Session::get('DependenciaIdArray');
            $Dependencias = Dependencia::all()->whereIn('id',$DependenciaIdArray,false)->sortBy('dependencia');

        }else{
            $Dependencias = Dependencia::all()->sortBy('dependencia');
        }


        $Servicios = Servicio::getQueryServiciosFromDependencias($item->dependencia_id);

        $user_ubicacion = $item->Ciudadano->ubicaciones->first->id->id;

        if ( $user_ubicacion == $item->ubicacion_id ){
            $pregunta1 = 0;
        }else{
            $pregunta1 = 1;
        }

        if (Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN') ) {
            $Estatus      = Estatu::all()->sortBy('estatus');
        }else{
            $Estatus      = Estatu::all()->where('estatus_cve',1)->sortBy('estatus');
        }

        $hashtag = Denuncia::select('clave_identificadora')->distinct('clave_identificadora')->orderBy('clave_identificadora')->pluck('clave_identificadora','clave_identificadora');

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
//            $data[]=array('value'=>$item->id.' '.$item->calle.' '.$item->colonia.' '.$item->comunidad,' '.$item->ciudad,'id'=>$item->id);
            $data[]=array('value'=>$item->calle.' '.$item->num_ext.' '.$item->num_int.' '.$item->colonia.' '.$item->comunidad,' '.$item->ciudad,'id'=>$item->id);
        }
        if(count($data))
            return $data;
        else
            return ['value'=>'No se encontraron resultados','id'=>0];
//        return Response::json(['mensaje' => 'OK', 'data' => json_decode($data), 'status' => '200'], 200);

    }

// ***************** MAUTOCOMPLETE DE UBICACIONES ++++++++++++++++++++ //
    protected function getUbi($IdUbi=0)
    {
        $items = Ubicacion::find($IdUbi);
        return Response::json(['mensaje' => 'OK', 'data' => json_decode($items), 'status' => '200'], 200);
    }

    protected function showModalSearchDenuncia(){

        if (Auth::user()->isRole('ENLACE')){

//            $dep_id = intval(Auth::user()->IsEnlaceDependencia);
            $DependenciaIdArray = Auth::user()->DependenciaIdArray;
//            $dependencia_id_array = explode('|',$DependenciaIdArray);
            $dependencia_id_array = $DependenciaIdArray;
            $Dependencias = Dependencia::all()->whereIn('id',$dependencia_id_array)->sortBy('dependencia')->pluck('dependencia','id');
            $dep_id = $dependencia_id_array[0];
            $Servicios = Servicio::whereHas('subareas', function($p) use ($dep_id) {
                $p->whereHas("areas", function($q) use ($dep_id){
                    return $q->where("dependencia_id",$dep_id);
                });
            })->orderBy('servicio')->get()->pluck('servicio','id');

        }else{
            $Dependencias = Dependencia::all()->sortBy('dependencia')->pluck('dependencia','id');
            $Servicios    = Servicio::all()->where('')->sortBy('servicio')->pluck('servicio','id');
        }

        if(Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN')){
            $Estatus      = Estatu::all()->sortBy('estatus');
        }else{
            $Estatus      = Estatu::all()->where('estatus_cve',1)->sortBy('estatus');
        }

        $Origenes     = Origen::all()->sortBy('origen');

        $Capturistas  = User::query()->whereHas('roles', function ($q) {
            return $q->whereIn('name',array('ENLACE','USER_OPERATOR_SIAC','USER_OPERATOR_ADMIN') );
        } )
            ->get()
            ->sortBy('full_name_with_username_dependencia')
            ->pluck('full_name_with_username_dependencia','id');

        // $hashtag = Denuncia::query()->select('clave_identificadora')->distinct()->get();
        $hashtag = Denuncia::select('clave_identificadora')->distinct('clave_identificadora')->orderBy('clave_identificadora')->pluck('clave_identificadora','clave_identificadora');

//        dd($hashtag);


        $user = Auth::user();
        return view ('SIAC.denuncia.search.denuncia_search_panel',
            [
                'findDataInDenuncia' => 'findDataInDenuncia',
                'dependencias'       => $Dependencias,
                'capturistas'        => $Capturistas,
                'servicios'          => $Servicios,
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

        $items = Denuncia::query()
            ->filterBy($queryFilters)
            ->orderByDesc('id')
            ->paginate($this->max_item_for_query);

//        Denuncia_Dependencia_Servicio::query()
//            Denuncia_Dependencia_Servicio

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
            ]
        );

    }

// ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
    protected function getServiciosFromDependencias($id= 0){


//        dd($id);

        $item = Servicio::getQueryServiciosFromDependencias($id);

        if (isset($item)) {
            return Response::json(['mensaje' => 'OK', 'data' => $item, 'status' => '200'], 200);
        } else {
            return Response::json(['mensaje' => 'Error', 'data' => dd($item), 'status' => '200'], 200);
        }

    }

    protected function closeItem($id){
        $item    = Denuncia::find($id);
        $estatus = Estatu::all()->where('estatus','CERRADO')->first();
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

//        $item = Denuncia::find($request['id']);
//        if ($item->cerrado == false){
//            $item->ciudadanos()->detach($request['usuario_id']);
//            $item->ciudadanos()->attach($request['usuario_id']);
//        }

        return $this->addUserToDemanda($request['id'], $request['usuario_id']);
    }

    private function addUserToDemanda($id, $usuario_id){
        $item = Denuncia::find($id);
        if ($item->cerrado == false){
            $item->ciudadanos()->detach($usuario_id);
            $item->ciudadanos()->attach($usuario_id);
        }
        return Redirect::back();
    }


    protected function searchIdentical(SearchIdenticalRequest $request){
        $items = $request->manage();
        if ( $items == [] ) {
            return Response::json(['mensaje' => 'No hay datos', 'result_msg' => 'Error', 'data' => null, 'status' => '200'], 200);
        }
        return Response::json(['mensaje' => count($items).' registros(s).', 'result_msg' => 'OK', 'data' => $items, 'status' => '200'], 200);
    }


    protected function removeAddUserDenuncia($id0 = 0, $id1 = 0){

        $item = Denuncia::find($id0);
        $item->ciudadanos()->detach($id1);
        return Response::json(['mensaje' => 'Eliminado', 'data' => 'OK', 'status' => '200'], 200);

    }



}
