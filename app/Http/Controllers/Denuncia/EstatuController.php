<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Requests\Denuncia\StatuRequest;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Estatu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class EstatuController extends Controller{

    protected $tableName = "Status";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Estatu::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('SIAC.estructura.estatu.estatu_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listEstatus',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editEstatuV2',
                'newItem'         => 'newEstatuV2',
                'removeItem'      => 'removeEstatu',
                'IsModal'         => true,
                'IsModalNew'      => true,
                'IsModalEdit'     => true,
                'exportModel'     => 24,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItem()
    {
        $Dependencias = Dependencia::select('id','dependencia')
            ->orderBy('dependencia')
            ->get();
        return view('SIAC.estructura.estatu.estatu_modal',
            [
                'dependencia' => $Dependencias,
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createEstatu',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro',
            ]
        );
    }

    protected function createItem(StatuRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listEstatus');
    }

    // ***************** CREAR NUEVO MODAL ++++++++++++++++++++ //
    protected function newItemV2()
    {
        $Dependencias = Dependencia::select('id','dependencia')
            ->orderBy('dependencia')
            ->get();
        $user = Auth::user();
        $ambito = FuncionesController::arrAmbitosDependencia();

        return view('SIAC.estructura.estatu.estatu_modal',
            [
                'Titulo'          => 'Nueva',
                'Route'           => 'createEstatuV2',
                'Method'          => 'POST',
                'items_forms'     => 'SIAC.estructura.estatu.__estatu.__estatu_new',
                'IsNew'           => true,
                'user'            => $user,
                'dependencia'     => $Dependencias,
                'ambito'          => $ambito,
            ]
        );

    }

    protected function createItemV2(StatuRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newEstatuV2')
                ->withErrors($Obj)
                ->withInput();
        }else{
            $id = $Obj->id;
        }
        return Response::json(['mensaje' => 'Dato agregado con éxito', 'data' => 'OK', 'status' => '200'], 200);
    }


// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItem($Id)
    {
        $Dependencias = Dependencia::select('id','dependencia')
            ->orderBy('dependencia')
            ->get();
        $item = Estatu::find($Id);
        return view('catalogos.catalogo.estatu.estatu_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateEstatu',
                'dependencia' => $Dependencias,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(StatuRequest $request)
    {
        $item = $request->manage();
//        dd($item);
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listEstatus');
    }


// ***************** EDITA LOS DATOS  MODAL ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $Dependencias = Dependencia::select('id','dependencia')
            ->orderBy('dependencia')
            ->get();
        $item = Estatu::find($Id);
//        dd($item);
        $user = Auth::user();

        $ambito = FuncionesController::arrAmbitosDependencia();

        return view('SIAC.estructura.estatu.estatu_modal',
            [

                'Titulo'          => isset($item->subarea) ? $item->subarea : 'Nueva',
                'Route'           => 'updateEstatuV2',
                'Method'          => 'POST',
                'items_forms'     => 'SIAC.estructura.estatu.__estatu.__estatu_edit',
                'IsNew'           => false,
                'IsModal'         => true,
                'IsModalEdit'     => true,
                'items'           => $item,
                'user'            => $user,
                'dependencia'     => $Dependencias,
                'ambito'          => $ambito,
            ]
        );

    }

    protected function updateItemV2(StatuRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = $request->all(['id']);
            $redirect = 'editEstatuV2/' . $id;
            return redirect($redirect)
                ->withErrors($Obj)
                ->withInput();
        }else{
            $id = $Obj->id;
        }
        return Response::json(['mensaje' => 'Dato agregado con éxito', 'data' => 'OK', 'status' => '200'], 200);
    }

// ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
    protected function removeItem($id = 0)
    {
        $item = Estatu::withTrashed()->findOrFail($id);
        if ( strtoupper(trim($item->estatus)) === "CERRADO"){
            return Response::json(['mensaje' => 'No se puede eliminar ese Estatus', 'data' => 'Error', 'status' => '200'], 200);
        }else{

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

    protected function addDepEstatu($Id,$IdDep)
    {
        $Estatu = Estatu::find($Id);
        $Estatu->dependencias()->attach($IdDep);
        return Response::json(['mensaje' => 'OK'], 200);
    }

    protected function removeDepEstatu($Id,$IdDep)
    {
        $Estatu = Estatu::find($Id);
        $Estatu->dependencias()->detach($IdDep);
        return Response::json(['mensaje' => 'OK'], 200);
    }

}
