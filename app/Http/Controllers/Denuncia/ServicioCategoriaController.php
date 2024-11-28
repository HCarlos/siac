<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Denuncia\ServicioCategoriaRequest;
use App\Models\Catalogos\ServicioCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ServicioCategoriaController extends Controller{



    protected $tableName = "serviciocategorias";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = ServicioCategoria::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');

//        dd($items);

        $user = Auth::User();

        return view('SIAC.estructura.serviciocategoria.serviciocategoria_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listServiciosCategorias',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editServicioCategoria',
                'newItem'         => 'newServicioCategoria',
                'removeItem'      => 'removeServicioCategoria',
                'IsModal'         => true,
                'exportModel'     => 26,
            ]
        );
    }


    // ***************** CREAR NUEVO MODAL ++++++++++++++++++++ //
    protected function newItemV2()
    {
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nueva',
                'Route'       => 'createServicioCategoria',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.estructura.serviciocategoria.__serviciocategoria.__serviciocategoria_new',
                'IsNew'       => true,
                'user'        => $user,

            ]
        );
    }

    protected function createItemV2(ServicioCategoriaRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newServicioCategoria')
                ->withErrors($Obj)
                ->withInput();
        }else{
            $id = $Obj->id;
        }
        return Response::json(['mensaje' => 'Dato agregado con éxito', 'data' => 'OK', 'status' => '200'], 200);
    }


// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = ServicioCategoria::find($Id);
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Editanto la categoría: ' . $item->id,
                'Route'       => 'updateServicioCategoria',
                'Method'      => 'POST',
                'items'       => $item,
                'items_forms' => 'SIAC.estructura.serviciocategoria.__serviciocategoria.__serviciocategoria_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'user'        => $user,

            ]
        );
    }

    protected function updateItemV2(ServicioCategoriaRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editServicioCategoria')
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
        $item = ServicioCategoria::withTrashed()->findOrFail($id);
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
