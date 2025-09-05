<?php

namespace App\Http\Controllers\Denuncia;

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Requests\Denuncia\DenunciaDependenciaServicioAmbitoRequest;
use App\Http\Requests\Denuncia\DenunciaDependenciaServicioRequest;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\_viServicios;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class DenunciaDependenciaServicioAmbitoController extends Controller
{

    protected $tableName = "denuncia_dependencia_servicio";
    protected $Id = 0;
    protected $msg = "";
    protected $ambito_dependencia = 1;
    protected $estatus_ids = "";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //

    /**
     * @param string $tableName
     */
    public function __construct() {
        $this->middleware('auth');
    }

    protected function index(Request $request, $Id){
        ini_set('max_execution_time', 300);

        $Denuncia = Denuncia::find($Id);

        if ($Denuncia !== null) {


            $items = Denuncia_Dependencia_Servicio::query()->where('denuncia_id', $Id)->orderBy('id')->paginate();
            $items->appends('id')->fragment('table');


            $request->session()->put('items', $items);
            $this->ambito_dependencia = Session::get('ambito_dependencia');

            session(['msg' => '']);

            $user = Auth::User();
            $this->Id = $Id;

            Denuncia_Dependencia_Servicio::where('denuncia_id', $Id)->update(['fue_leida' => true]);

            return view('SIAC.denuncia.denuncia_dependencia_servicio_ambito.denuncia_dependencia_servicio_ambito_list',
                [
                    'items' => $items,
                    'Id' => $this->Id,
                    'Denuncia' => $Denuncia,
                    'titulo_catalogo' => "Cronología de cambios de estatus de la orden: " . $this->Id,
                    'user' => $user,
                    'newWindow' => true,
                    'newItem' => 'addDenunciaDependenciaServicioAmbito',
                    'tableName' => $this->tableName,
                    'showEdit' => 'editDenunciaDependenciaServicioAmbito',
                    'showProcess1' => 'showDataListDenunciaAmbitoRespuestaExcel1A',
                    'postNew' => 'postAddDenunciaDependenciaServicioAmbito',
                    'addItem' => 'addDenunciaDependenciaServicioAmbito',
                    'removeItem' => 'removeDenunciaDependenciaServicio',
                    'imprimirDenuncia' => "imprimirDenuncia/",
                    'imprimirDenunciaConRespuesta' => "imprimir_denuncia_respuesta/",
                    'showEditDenunciaDependenciaServicio' => 'listDenunciaDependenciaServicioAmbito',
                    'imagenesDenunciaItem' => 'listImagenes',
                ]
            );
        }else{
            return \redirect()->route('home');
        }
    }

// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItem($Id){

        $items        = Denuncia_Dependencia_Servicio::find($Id);
        if ($items != null) {

            $Denuncia = Denuncia::find($items->denuncia_id);
            $user_id = Auth::user()->id;

            $IsEnlace = Auth::user()->isRole('ENLACE');
            $this->ambito_dependencia = Session::get('ambito_dependencia');

            if ($IsEnlace) {
                $dep_id = Auth::user()->IsEnlaceDependencia;
//            dd($dep_id);
                $Dependencias = Dependencia::query()
                    ->where("estatus_cve", 1)
                    ->whereIn('id', $dep_id)
                    ->orderBy('dependencia')
                    ->get();

                $Servicios = _viServicios::query()->where('dependencia_id', $items->dependencia_id)->get()->sortBy($items->servicio);

            } else {

                $Dependencias = Dependencia::query()
                    ->where('ambito_dependencia', $this->ambito_dependencia)
                    ->where("estatus_cve", 1)
                    ->orderBy('dependencia')
                    ->get();

                $Servicios = _viServicios::query()->where('dependencia_id', $items->dependencia_id)->get()->sortBy($items->servicio);

            }

            if (Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN')) {
                $Estatus = Estatu::query()
                    ->whereIn('ambito_estatus', [1, 2])
                    ->orderBy('orden_impresion')
                    ->get();
            } else {
                $Estatus = Estatu::query()
                    ->where('estatus_cve', 1)
                    ->whereIn('ambito_estatus', [1, 2])
                    ->whereHas('users', function ($q) use ($user_id) {
                        return $q->where("user_id", $user_id);
                    })
                    ->orderBy('orden_impresion')
                    ->get();

            }

            // Obtenemos el array de Estatus utilizados
            $arStsId = Denuncia_Dependencia_Servicio::query()
                ->select('estatu_id')
                ->where('denuncia_id', $Denuncia->id)
                ->where('dependencia_id', $Denuncia->Dependencia->id)
                ->where('servicio_id', $Denuncia->Servicio->id)
                ->get();
            foreach ($arStsId as $stsId) {
                $this->estatus_ids .=  $this->estatus_ids === "" ? $stsId->estatu_id : ",".$stsId->estatu_id;
            }

            return view('SIAC.denuncia.denuncia_dependencia_servicio_ambito.denuncia_dependencia_servicio_ambito_edit',
                [
                    'user' => Auth::user(),
                    'items' => $items,
                    'Id' => $Id,
                    'dependencias' => $Dependencias,
                    'servicios' => $Servicios,
                    'estatus' => $Estatus,
                    'editItemTitle' => "Agregando servicio a la solicitud " . $Id,
                    'postNew' => 'putAddDenunciaDependenciaServicioAmbito',
                    'titulo_catalogo' => "Editando el Id: " . $Id,
                    'titulo_header' => 'de la Solicitud ' . $Denuncia->id,
                    'ambito_dependencia' => $this->ambito_dependencia,
                    'denuncia' => $Denuncia,
                    'removeItem' => 'removeImagene',
                    'lista_estatus_utilizados' => $this->estatus_ids,
                ]
            );
        }else{
            return \redirect()->route('home');
        }
    }

// ***************** GUARDA LOS CAMBIOS ++++++++++++++++++++ //
    protected function putEdit(DenunciaDependenciaServicioAmbitoRequest $request){
        $denuncia_id = $request["denuncia_id"];
        $Id = $request->manage();
        if  (!isset($Id)) {
            return '<script type="text/javascript">alert("'.$Id.'");</script>';
        }
        return Redirect::to('listDenunciaDependenciaServicioAmbito/'.$denuncia_id);
    }


    protected function addItem($Id){

        $denuncia = Denuncia::find($Id);

        if ($denuncia != null) {


            $items = Denuncia_Dependencia_Servicio::query()->where('denuncia_id', $Id)->orderByDesc('id')->first();


            $user_id = Auth::user()->id;
            $this->ambito_dependencia = Session::get('ambito_dependencia');

            $IsEnlace = Auth::user()->isRole('ENLACE');
            if ($IsEnlace) {
                $dep_id = Auth::user()->IsEnlaceDependencia;

                $Dependencias = Dependencia::query()
                    ->where("estatus_cve", 1)
                    ->whereIn('id', $dep_id)
                    ->orderBy('dependencia')
                    ->get();

                $Servicios = _viServicios::query()->where('dependencia_id', $items->dependencia_id)->get()->sortBy($items->servicio);

                $servicio_id = $items->servicio_id;
            } else {

//                ->where('ambito_dependencia', $this->ambito_dependencia)

                $Dependencias = Dependencia::query()
                    ->whereIn('ambito_dependencia', [1,2])
                    ->where("estatus_cve", 1)
                    ->orderBy('dependencia')
                    ->get();

                $Servicios = _viServicios::query()->where('dependencia_id', $items->dependencia_id)->get()->sortBy($items->servicio);

                $servicio_id = $items->servicio_id;

            }

            if (Auth::user()->isRole('Administrator|SysOp|USER_OPERATOR_ADMIN|USER_ARCHIVO_ADMIN')) {
                $Estatus = Estatu::query()
                    ->whereIn('ambito_estatus', [1, 2])
                    ->orderBy('orden_impresion')
                    ->get();
            } else {
                $Estatus = Estatu::query()
                    ->where('estatus_cve', 1)
                    ->whereIn('ambito_estatus', [1, 2])
                    ->whereHas('users', function ($q) use ($user_id) {
                        return $q->where("user_id", $user_id);
                    })
                    ->orderBy('orden_impresion')
                    ->get();
            }

            // Obtenemos el array de Estatus utilizados
            $arStsId = Denuncia_Dependencia_Servicio::query()
                ->select('estatu_id')
                ->where('denuncia_id', $Id)
                ->where('dependencia_id', $denuncia->Dependencia->id)
                ->where('servicio_id', $denuncia->Servicio->id)
                ->get();
            foreach ($arStsId as $stsId) {
                $this->estatus_ids .=  $this->estatus_ids === "" ? $stsId->estatu_id : ",".$stsId->estatu_id;
            }

            return view('SIAC.denuncia.denuncia_dependencia_servicio_ambito.denuncia_dependencia_servicio_ambito_new',
                [
                    'user' => Auth::user(),
                    'items' => $items,
                    'Id' => $Id,
                    'editItemTitle' => 'Nuevo',
                    'dependencias' => $Dependencias,
                    'dependencia_id' => $items->dependencia_id,
                    'servicio_id' => $servicio_id,
                    'servicios' => $Servicios,
                    'estatus' => $Estatus,
                    'postNew' => 'postAddDenunciaDependenciaServicioAmbito',
                    'titulo_catalogo' => "Nuevo cambio de estatus de la orden: " . $Id,
                    'titulo_header' => 'Agregar dependencia',
                    'exportModel' => 23,
                    'ambito_dependencia' => $this->ambito_dependencia,
                    'denuncia' => $denuncia,
                    'removeItem' => 'removeImagene',
                    'lista_estatus_utilizados' => $this->estatus_ids,
                ]
            );
        }

        return \redirect()->route('home');
    }


    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function postNew(DenunciaDependenciaServicioAmbitoRequest $request){
        $denuncia_id = $request["denuncia_id"];
        $this->ambito_dependencia = Session::get('ambito_dependencia');
        $Id = $request->manage();
        if (!isset($Id)) {
            return '<script type="text/javascript">alert("'.$Id.'");</script>';
        }
        return Redirect::to('listDenunciaDependenciaServicioAmbito/'.$denuncia_id);
    }

    // ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
        protected function removeItem($id = 0){

            $item = Denuncia_Dependencia_Servicio::withTrashed()->findOrFail($id);
            $denuncia_id = $item->denuncia_id;
            if (isset($item)) {
                if (!$item->trashed()) {
                    $item->forceDelete();
                } else {
                    $item->forceDelete();
                }
                $vid = new VistaDenunciaClass();
                $vid->vistaDenuncia($denuncia_id);
                return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
            } else {
                return Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
            }

        }

    protected function lastDepDen(Request $request){
        $dependecia_id = (int)$request["dependencia_id"];
        $denuncia_id = (int)$request["denuncia_id"];

//        dd($denuncia_id);
//
        $items = Denuncia_Dependencia_Servicio::where('denuncia_id', $denuncia_id)
            ->where('dependencia_id', $dependecia_id)
            ->orderBy('servicio_id', 'desc')
            ->first();

//        dd($items);

        if ($items === null) {
            return Response::json(['mensaje' => 'Error', 'data' => 'Error', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'OK', 'data' => 'OK', 'status' => '200'], 200);
        }
    }






}
