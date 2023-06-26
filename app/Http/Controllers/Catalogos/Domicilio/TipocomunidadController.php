<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domicilio\TipocomunidadRequest;
use App\Models\Catalogos\Domicilios\Tipocomunidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class TipocomunidadController extends Controller
{


    protected $tableName = "Tipos de Comunidades";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Tipocomunidad::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate();
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('SIAC.domicilio.tc.tc_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listTipocomunidades',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editTipocomunidadV2',
                'newItem'         => 'newTipocomunidadV2',
                'removeItem'      => 'removeTipocomunidad',
                'IsModal'         => true,
                'exportModel'     => 17,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItem()
    {
        return view('catalogos.catalogo.domicilio.tc.tc_new',
            [
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createTipocomunidad',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro',
            ]
        );
    }

    protected function createItem(TipocomunidadRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listTipocomunidades');
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItemV2(){
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nuevo',
                'Route'       => 'createTipocomunidadV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.tc.__tc.__tc_new',
                'IsNew'       => true,
                'user'        => $user,
            ]
        );
    }

    protected function createItemV2(TipocomunidadRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newTipocomunidadV2')
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
        $item = Tipocomunidad::find($Id);
        return view('catalogos.catalogo.domicilio.tc.tc_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateTipocomunidad',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(TipocomunidadRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listTipocomunidades');
    }

// ***************** EDITA LOS DATOS MODAL ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Tipocomunidad::find($Id);
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Editando el Item. '.$Id,
                'Route'       => 'updateTipocomunidadV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.tc.__tc.__tc_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'items'       => $item,
                'user'        => $user,
            ]
        );
    }

    protected function updateItemV2(TipocomunidadRequest $request){
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editTipocomunidadV2/'.$request->all(['id']))
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
        $item = Tipocomunidad::withTrashed()->findOrFail($id);
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
