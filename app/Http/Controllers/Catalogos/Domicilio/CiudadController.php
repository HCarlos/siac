<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domicilio\CiudadRequest;
use App\Models\Catalogos\Domicilios\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class CiudadController extends Controller
{


    protected $tableName = "Ciudades";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Ciudad::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('catalogos.catalogo.domicilio.ciudad.ciudad_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listCiudades',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editCiudadV2',
                'newItem'         => 'newCiudadV2',
                'removeItem'      => 'removeCiudad',
                'IsModal'         => true,
                'exportModel'     => 9,
            ]
        );
    }

    protected function newItem()
    {
        return view('catalogos.catalogo.domicilio.ciudad.ciudad_new',
            [
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createCiudad',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro ',
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function createItem(CiudadRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listCiudades');
    }

    protected function newItemV2(){
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nueva',
                'Route'       => 'createCiudadV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.ciudad.__ciudad.__ciudad_new',
                'IsNew'       => true,
                'user'        => $user,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function createItemV2(CiudadRequest $request){
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newCiudadV2')
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
        $item = Ciudad::find($Id);
        return view('catalogos.catalogo.domicilio.ciudad.ciudad_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateCiudad',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(CiudadRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listCiudades');
    }


// ***************** EDITA LOS DATOS MODAL ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Ciudad::find($Id);
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nueva',
                'Route'       => 'updateCiudadV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.ciudad.__ciudad.__ciudad_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'items'       => $item,
                'user'        => $user,
            ]
        );
    }

    protected function updateItemV2(CiudadRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editCiudadV2')
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
        $item = Ciudad::withTrashed()->findOrFail($id);
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
