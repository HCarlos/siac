<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domicilio\CodigopostalRequest;
use App\Models\Catalogos\Domicilios\Codigopostal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class CodigopostalController extends Controller
{


    protected $tableName = "Codigos Postales";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Codigopostal::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('catalogos.catalogo.domicilio.cp.cp_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listCodigopostales',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editCodigopostalV2',
                'newItem'         => 'newCodigopostalV2',
                'removeItem'      => 'removeCodigopostal',
                'IsModal'         => true,
                'exportModel'     => 10,
            ]
        );
    }

// ***************** CREA UN NUEVO CÓDIGO POSTAL  ++++++++++++++++++++ //
    protected function newItem()
    {
        return view('catalogos.catalogo.domicilio.cp.cp_new',
            [
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createCodigopostal',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro ',
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function createItem(CodigopostalRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listCodigopostales');
    }

// ***************** CREA UN NUEVO CÓDIGO POSTAL MODAL ++++++++++++++++++++ //
    protected function newItemV2()
    {

        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nueva',
                'Route'       => 'createCodigopostalV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.cp.__cp.__cp_new',
                'IsNew'       => true,
                'user'        => $user,
            ]
        );


    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function createItemV2(CodigopostalRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newCodigopostalV2')
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
        $item = Codigopostal::find($Id);
        return view('catalogos.catalogo.domicilio.cp.cp_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateCodigopostal',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(CodigopostalRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listCodigopostales');
    }

// ***************** EDITA LOS DATOS MODAL ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Codigopostal::find($Id);
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Editando el Item. '.$Id,
                'Route'       => 'updateCodigopostalV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.cp.__cp.__cp_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'items'       => $item,
                'user'        => $user,
            ]
        );


    }

    protected function updateItemV2(CodigopostalRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editCodigopostalV2')
                ->withErrors($Obj)
                ->withInput();
        }else{
            $id = $Obj->id;
        }
        return Response::json(['mensaje' => 'Dato agregado con éxito', 'data' => 'OK', 'status' => '200'], 200);

    }




// ***************** MAUTOCOMPLETE DE UBICACIONES ++++++++++++++++++++ //
    protected function buscarCodigopostal(Request $request)
    {
        ini_set('max_execution_time', 300000);
        $filters = $request->all(['search']);
        $items = Codigopostal::query()
            ->filterBy($filters)
            ->orderBy('id')
            ->get();

        $data=array();

        foreach ($items as $item) {
            $data[]=array('value'=>$item->cp,'id'=>$item->id);
        }
        if(count($data))
            return $data;
        else
            return ['value'=>'No se encontraron calles','id'=>0];

    }

// ***************** MAUTOCOMPLETE DE UBICACIONES ++++++++++++++++++++ //
    protected function getCodigopostal($IdCodigopostal=0)
    {
        $items = Codigopostal::find($IdCodigopostal);
        return Response::json(['mensaje' => 'OK', 'data' => json_decode($items), 'status' => '200'], 200);

    }




    // ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
    protected function removeItem($id = 0)
    {
        $item = Codigopostal::withTrashed()->findOrFail($id);
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
