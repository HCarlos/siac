<?php

namespace App\Http\Controllers\Denuncia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\Origen;
use App\Http\Requests\Denuncia\OrigenRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class OrigenController extends Controller
{


    protected $tableName = "Origenes";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Origen::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('catalogos.catalogo.origen.origen_list',
            [
                'items' => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listOrigenes',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editOrigenV2',
                'newItem'         => 'newOrigenV2',
                'removeItem'      => 'removeOrigen',
                'IsModal'         => true,
                'exportModel'     => 26,
            ]
        );
    }


    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItem()
    {
        return view('catalogos.catalogo.origen.origen_new',
            [
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createOrigen',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro',
            ]
        );
    }

    protected function createItem(OrigenRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listOrigenes');
    }

    // ***************** CREAR NUEVO MODAL ++++++++++++++++++++ //
    protected function newItemV2()
    {
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nuevo',
                'Route'       => 'createOrigenV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.estructura.origen.__origen.__origen_new',
                'IsNew'       => true,
                'user'        => $user,

            ]
        );
    }

    protected function createItemV2(OrigenRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newOrigenV2')
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
        $item = Origen::find($Id);
        return view('catalogos.catalogo.origen.origen_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateOrigen',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(OrigenRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listOrigenes');
    }


// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Origen::find($Id);
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nuevo',
                'Route'       => 'updateOrigenV2',
                'Method'      => 'POST',
                'items'       => $item,
                'items_forms' => 'SIAC.estructura.origen.__origen.__origen_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'user'        => $user,

            ]
        );
    }

    protected function updateItemV2(OrigenRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editOrigenV2')
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
        $item = Origen::withTrashed()->findOrFail($id);
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
