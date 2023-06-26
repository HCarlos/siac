<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Denuncia\MedidaRequest;
use App\Models\Catalogos\Medida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class MedidaController extends Controller
{

    protected $tableName = "Medidas";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Medida::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('catalogos.catalogo.medida.medida_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listMedidas',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editMedidaV2',
                'newItem'         => 'newMedidaV2',
                'removeItem'      => 'removeMedida',
                'IsModal'         => true,
                'exportModel'     => 25,
            ]
        );
    }



    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItem()
    {
        return view('catalogos.catalogo.medida.medida_new',
            [
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createMedida',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro',
            ]
        );
    }

    protected function createItem(MedidaRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listMedidas');
    }


    // ***************** CREAR NUEVO MODAL ++++++++++++++++++++ //
    protected function newItemV2()
    {
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nuevo',
                'Route'       => 'createMedidaV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.estructura.medida.__medida.__medida_new',
                'IsNew'       => true,
                'user'        => $user,

            ]
        );

    }

    protected function createItemV2(MedidaRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newMedidaV2')
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
        $item = Medida::find($Id);
        return view('catalogos.catalogo.medida.medida_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateMedida',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(MedidaRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listMedidas');
    }

// ***************** EDITA LOS DATOS MODAL ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Medida::find($Id);
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nuevo',
                'Route'       => 'updateMedidaV2',
                'Method'      => 'POST',
                'items'       => $item,
                'items_forms' => 'SIAC.estructura.medida.__medida.__medida_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'user'        => $user,

            ]
        );

    }

    protected function updateItemV2(MedidaRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editMedidaV2')
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
        $item = Medida::withTrashed()->findOrFail($id);
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
