<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Http\Requests\Domicilio\CiudadRequest;
use App\Models\Catalogos\Domicilios\Ciudad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Domicilio\LocalidadRequest;
use App\Models\Catalogos\Domicilios\Localidad;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class LocalidadController extends Controller
{

    protected $tableName = "Localidades";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Localidad::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('catalogos.catalogo.domicilio.localidad.localidad_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listLocalidades',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editLocalidadV2',
                'newItem'         => 'newLocalidadV2',
                'removeItem'      => 'removeLocalidad',
                'IsModal'         => true,
                'exportModel'     => 14,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItem()
    {
        return view('catalogos.catalogo.domicilio.localidad.localidad_new',
            [
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createLocalidad',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro',
            ]
        );
    }

    protected function createItem(LocalidadRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listLocalidades');
    }

    // ***************** CREAR NUEVO VIA MODAL++++++++++++++++++++ //
    protected function newItemV2()
    {
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nueva',
                'Route'       => 'createLocalidadV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.localidad.__localidad.__localidad_new',
                'IsNew'       => true,
                'user'        => $user,
            ]
        );
    }

    protected function createItemV2(LocalidadRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newLocalidadV2')
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
        $item = Localidad::find($Id);
        return view('catalogos.catalogo.domicilio.localidad.localidad_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateLocalidad',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(LocalidadRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listLocalidades');
    }


// ***************** EDITA LOS DATOS MODAL ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Localidad::find($Id);
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Editando el Item. '.$Id,
                'Route'       => 'updateLocalidadV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.localidad.__localidad.__localidad_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'items'       => $item,
                'user'        => $user,
            ]
        );
    }

    protected function updateItemV2(LocalidadRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editLocalidadV2')
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
        $item = Localidad::withTrashed()->findOrFail($id);
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
