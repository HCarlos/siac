<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domicilio\TipoasentamientoRequest;
use App\Models\Catalogos\Domicilios\Tipoasentamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class TipoasentamientoController extends Controller
{


    protected $tableName = "Tipos de Asentamientos";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Tipoasentamiento::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate();
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('SIAC.domicilio.ta.ta_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listTipoasentamientos',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editTipoasentamientoV2',
                'newItem'         => 'newTipoasentamientoV2',
                'removeItem'      => 'removeTipoasentamiento',
                'IsModal'         => true,
                'exportModel'     => 16,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItem()
    {
        return view('catalogos.catalogo.domicilio.ta.ta_new',
            [
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createTipoasentamiento',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro',
            ]
        );
    }

    protected function createItem(TipoasentamientoRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listTipoasentamientos');
    }

    // ***************** CREAR NUEVO MODAL++++++++++++++++++++ //
    protected function newItemV2()
    {
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nuevo',
                'Route'       => 'createTipoasentamientoV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.ta.__ta.__ta_new',
                'IsNew'       => true,
                'user'        => $user,
            ]
        );
    }

    protected function createItemV2(TipoasentamientoRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newTipoasentamientoV2')
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
        $item = Tipoasentamiento::find($Id);
        return view('catalogos.catalogo.domicilio.ta.ta_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateTipoasentamiento',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(TipoasentamientoRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listTipoasentamientos');
    }

// ***************** EDITA LOS DATOS  MODAL ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Tipoasentamiento::find($Id);
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Editando el Item. '.$Id,
                'Route'       => 'updateTipoasentamientoV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.ta.__ta.__ta_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'items'       => $item,
                'user'        => $user,
            ]
        );
    }

    protected function updateItemV2(TipoasentamientoRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editTipoasentamientoV2/'.$request->all(['id']))
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
        $item = Tipoasentamiento::withTrashed()->findOrFail($id);
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
