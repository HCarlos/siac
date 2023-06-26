<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Denuncia\PrioridadRequest;
use App\Models\Catalogos\Prioridad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class PrioridadController extends Controller
{

    protected $tableName = "Prioridades";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Prioridad::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('catalogos.catalogo.prioridad.prioridad_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listPrioridades',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editPrioridadV2',
                'newItem'         => 'newPrioridadV2',
                'removeItem'      => 'removePrioridad',
                'IsModal'         => true,
                'exportModel'     => 27,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItem()
    {
        return view('catalogos.catalogo.prioridad.prioridad_new',
            [
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createPrioridad',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro',
            ]
        );
    }

    protected function createItem(PrioridadRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listPrioridades');
    }

    // ***************** CREAR NUEVO MODAL ++++++++++++++++++++ //
    protected function newItemV2()
    {
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nuevo',
                'Route'       => 'createPrioridadV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.estructura.prioridad.__prioridad.__prioridad_new',
                'IsNew'       => true,
                'user'        => $user,

            ]
        );
    }

    protected function createItemV2(PrioridadRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newPrioridadV2')
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
        $item = Prioridad::find($Id);
        return view('catalogos.catalogo.prioridad.prioridad_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updatePrioridad',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(PrioridadRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listPrioridades');
    }


// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Prioridad::find($Id);
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => isset($item->prioridad) ? $item->prioridad : 'Nuevo',
                'Route'       => 'updatePrioridadV2',
                'Method'      => 'POST',
                'items'       => $item,
                'items_forms' => 'SIAC.estructura.prioridad.__prioridad.__prioridad_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'user'        => $user,

            ]
        );
    }

    protected function updateItemV2(PrioridadRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editPrioridadV2')
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
        $item = Prioridad::withTrashed()->findOrFail($id);
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
