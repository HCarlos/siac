<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domicilio\AsentamientoRequest;
use App\Models\Catalogos\Domicilios\Asentamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class AsentamientoController extends Controller
{


    protected $tableName = "Asentamientos";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Asentamiento::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate();
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('SIAC.domicilio.asentamiento.asentamiento_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listAsentamientos',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editAsentamientoV2',
                'newItem'         => 'newAsentamientoV2',
                'removeItem'      => 'removeAsentamiento',
                'IsModal'         => true,
                'exportModel'     => 7,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItem()
    {
        return view('catalogos.catalogo.domicilio.asentamiento.asentamiento_new',
            [
                'editItemTitle'   => 'Nuevo',
                'postNew'         => 'createAsentamiento',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro ',
            ]
        );
    }

    protected function createItem(AsentamientoRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listAsentamientos');
    }

    // ***************** CREAR NUEVO MODAL ++++++++++++++++++++ //
    protected function newItemV2()
    {
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nueva',
                'Route'       => 'createAsentamientoV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.asentamiento.__asentamiento.__asentamiento_new',
                'IsNew'       => true,
                'user'        => $user,
            ]
        );
    }

    protected function createItemV2(AsentamientoRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newAsentamientoV2')
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
        $item = Asentamiento::find($Id);
        return view('catalogos.catalogo.domicilio.asentamiento.asentamiento_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateAsentamiento',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(AsentamientoRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listAsentamientos');
    }

// ***************** EDITA LOS DATOS  MODAL++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Asentamiento::find($Id);
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Editando el Item. '.$Id,
                'Route'       => 'updateAsentamientoV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.asentamiento.__asentamiento.__asentamiento_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'items'       => $item,
                'user'        => $user,
            ]
        );
    }

    protected function updateItemV2(AsentamientoRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editAsentamientoV2')
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
        $item = Asentamiento::withTrashed()->findOrFail($id);
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
