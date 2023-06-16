<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Requests\Denuncia\DenunciaDependenciaServicioRequest;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\Denuncia;
use App\Http\Controllers\Controller;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class DenunciaDependenciaServicioController extends Controller
{

    protected $tableName = "denuncia_dependencia_servicio";
    protected $Id = 0;
    protected $msg = "";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //

    /**
     * @param string $tableName
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function index(Request $request, $Id)
    {
        ini_set('max_execution_time', 300);

        $items = Denuncia_Dependencia_Servicio::query()->where('denuncia_id',$Id)->orderBy('id')->paginate();
        $items->appends('id')->fragment('table');

        $Denuncia = Denuncia::find($Id);

        $request->session()->put('items', $items);

        session(['msg' => '']);


        $user = Auth::User();
        $this->Id = $Id;

        return view('SIAC.denuncia.denuncia_dependencia_servicio.denuncia_dependencia_servicio_list',
            [
                'items'                               => $items,
                'Id'                                  => $this->Id,
                'Denuncia'                            => $Denuncia,
                'titulo_catalogo'                     => "Cronología de cambios de estatus de la orden: " . $this->Id,
                'titulo_header'                       => '',
                'user'                                => $user,
                'newWindow'                           => true,
                'newItem'                             => 'addDenunciaDependenciaServicio',
                'tableName'                           => $this->tableName,
                'showEdit'                            => 'editDenunciaDependenciaServicio',
                'showProcess1'                        => 'showDataListDenunciaRespuestaExcel1A',
                'postNew'                             => 'postAddDenunciaDependenciaServicio',
                'addItem'                             => 'addDenunciaDependenciaServicio',
                'removeItem'                          => 'removeDenunciaDependenciaServicio',
                'imprimirDenuncia'                    => "imprimirDenuncia/",
                'imprimirDenunciaConRespuesta'        => "imprimir_denuncia_respuesta/",
                'showEditDenunciaDependenciaServicio' =>'listDenunciaDependenciaServicio',
                'imagenesDenunciaItem'                => 'listImagenes',
            ]
        );
    }

// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItem($Id){
        $items        = Denuncia_Dependencia_Servicio::find($Id);
        $Denuncia     = Denuncia::find($items->denuncia_id);

        $IsEnlace = Auth::user()->isRole('ENLACE');
        if($IsEnlace){
            $dep_id = intval(Auth::user()->IsEnlaceDependencia);
            $Dependencias = Dependencia::all()->whereIn('id',$dep_id);
            $Servicios    = Servicio::getQueryServiciosFromDependencias($items->dependencia_id);
        }else{
            $Dependencias = Dependencia::all()->sortBy('dependencia');
            $Servicios    = Servicio::getQueryServiciosFromDependencias($items->dependencia_id);
        }

        if (Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN') ) {
            $Estatus      = Estatu::all()->sortBy('estatus');
        }else{
            $Estatus      = Estatu::all()->where('estatus_cve',1)->sortBy('estatus');
        }

        return view('SIAC.denuncia.denuncia_dependencia_servicio.denuncia_dependencia_servicio_edit',
            [
                'user'            => Auth::user(),
                'items'           => $items,
                'Id'              => $Id,
                'dependencias'    => $Dependencias,
                'servicios'       => $Servicios,
                'estatus'         => $Estatus,
                'editItemTitle'   => "Agregando servicio a la solicitud ".$Id,
                'postNew'         => 'putAddDenunciaDependenciaServicio',
                'titulo_catalogo' => "Editando el Id: " . $Id,
                'titulo_header'   => 'de la Solicitud '.$Denuncia->id,
            ]
        );
    }

// ***************** GUARDA LOS CAMBIOS ++++++++++++++++++++ //
    protected function putEdit(DenunciaDependenciaServicioRequest $request){
        $denuncia_id = $request["denuncia_id"];
//        dd( $denuncia_id );
        $Id = $request->manage();
        if  (!isset($Id)) {
            return '<script type="text/javascript">alert("'.$Id.'");</script>';
        }
        return Redirect::to('listDenunciaDependenciaServicio/'.$denuncia_id);
    }


    protected function addItem($Id){

        $items         = Denuncia::find($Id);

        $IsEnlace = Auth::user()->isRole('ENLACE');
        if($IsEnlace){
            $dep_id = Auth::user()->IsEnlaceDependencia;
            $Dependencias = Dependencia::all()->whereIn('id',$dep_id);
            $Servicios = Servicio::whereHas('subareas', function($p) use ($items) {
                $p->whereHas("areas", function($q) use ($items){
                    return $q->where("dependencia_id",$items->dependencia_id);
                });
            })->orderBy('servicio')->get();
//            $DDS = Denuncia_Dependencia_Servicio::all()->where('denuncia_id',$Id)->whereIn('dependencia_id',$dep_id);
            $servicio_id = $items->servicio_id;
        }else{
            $dep_id = $items->dependencia_id;
            $Dependencias = Dependencia::all()->sortBy('dependencia');
            $Servicios = Servicio::whereHas('subareas', function($p) use ($dep_id) {
                $p->whereHas("areas", function($q) use ($dep_id){
                    return $q->where("dependencia_id",$dep_id);
                });
            })->orderBy('servicio')->get();
            $servicio_id = $items->servicio_id;
        }

        if (Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN') ) {
            $Estatus      = Estatu::all()->sortBy('estatus');
        }else{
            $Estatus      = Estatu::all()->where('estatus_cve',1)->sortBy('estatus');
        }

        return view('SIAC.denuncia.denuncia_dependencia_servicio.denuncia_dependencia_servicio_new',
            [
                'user'              => Auth::user(),
                'items'             => $items,
                'Id'                => $Id,
                'editItemTitle'     => 'Nuevo',
                'dependencias'      => $Dependencias,
                'dependencia_id'    => $items->dependencia_id,
                'servicio_id'       => $servicio_id,
                'servicios'         => $Servicios,
                'estatus'           => $Estatus,
                'postNew'           => 'postAddDenunciaDependenciaServicio',
                'titulo_catalogo'   => "Nuevo cambio de estatus de la orden: " . $Id,
                'titulo_header'     => 'Agregar dependencia',
                'exportModel'       => 23,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function postNew(DenunciaDependenciaServicioRequest $request){
        $denuncia_id = $request["denuncia_id"];
//        dd( $denuncia_id );

        $Id = $request->manage();
        //dd($item);
        if (!isset($Id)) {
            return '<script type="text/javascript">alert("'.$Id.'");</script>';
        }
        return Redirect::to('listDenunciaDependenciaServicio/'.$denuncia_id);
    }

    // ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
        protected function removeItem($id = 0)
        {
            $item = Denuncia_Dependencia_Servicio::withTrashed()->findOrFail($id);
            if (isset($item)) {
                if (!$item->trashed()) {
                    $item->forceDelete();
                } else {
                    $item->forceDelete();
                }
                return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
            } else {
                return Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
            }
        }

}
