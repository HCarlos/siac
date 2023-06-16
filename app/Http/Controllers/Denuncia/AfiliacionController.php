<?php

namespace App\Http\Controllers\Denuncia;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\Afiliacion;
use App\Http\Requests\Denuncia\AfiliacionRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class AfiliacionController extends Controller
{


    protected $tableName = "Afiliaciones";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Afiliacion::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');
        $user = Auth::User();



        return view('catalogos.catalogo.afiliacion.afiliacion_list',
            [
                'items' => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user' => $user,
                'searchInList' => 'listAfiliaciones',
                'newWindow' => true,
                'tableName' => $this->tableName,
                'showEdit' => 'editAfiliacion',
//                'putEdit' => 'updateAfiliacion',
                'newItem' => 'newAfiliacion',
                'removeItem' => 'removeAfiliacion',
//                'showProcess1' => 'showFileListUserExcel1A',
                'exportModel' => 22,
            ]
        );
    }

// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItem($Id)
    {
        $item = Afiliacion::find($Id);
        return view('catalogos.catalogo.afiliacion.afiliacion_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateAfiliacion',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

// ***************** GUARDA LOS CAMBIOS ++++++++++++++++++++ //
    protected function updateItem(AfiliacionRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listAfiliaciones');
    }

    protected function newItem()
    {
        return view('catalogos.catalogo.afiliacion.afiliacion_new',
            [
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createAfiliacion',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro',
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function createItem(AfiliacionRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listAfiliaciones');
    }

// ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
    protected function removeItem($id = 0)
    {
        $item = Afiliacion::withTrashed()->findOrFail($id);
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
