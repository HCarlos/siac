<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domicilio\CalleRequest;
use App\Models\Catalogos\Domicilios\Calle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class CalleController extends Controller
{


    protected $tableName = "Calles";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $search = $filters['search'];
        $items = Calle::query()
            ->search($search)
            ->orderByDesc('id')
            ->paginate();
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

//        ->filterBy($filters)

        return view('catalogos.catalogo.domicilio.calle.calle_list',
            [
                'items' => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => ' ',
                'user'            => $user,
                'searchInList'    => 'listCalles',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editCalleV2',
                'newItem'         => 'newCalleV2',
                'removeItem'      => 'removeCalle',
                'IsModal'         => true,
                'exportModel'     => 8,
            ]
        );
    }


    protected function newItem()
    {
        return view('catalogos.catalogo.domicilio.calle.calle_new',
            [
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createCalle',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro ',
            ]
        );
    }

    protected function newItemV2()
    {
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nuevo',
                'Route'       => 'createCalleV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.domicilio.calle.__calle.__calle_new',
                'IsNew'       => true,
                'user'        => $user,

            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function createItem(CalleRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listCalles');
    }

    protected function createItemV2(CalleRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newCalleV2')
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
        $item = Calle::find($Id);
        return view('catalogos.catalogo.domicilio.calle.calle_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateCalle',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function editItemV2($Id){
        $item = Calle::find($Id);
        $user = Auth::user();
        return view('SIAC._comun.__modal_comun_1',
            [
                'Titulo'      => 'Nuevo',
                'Route'       => 'updateCalleV2',
                'Method'      => 'POST',
                'items'       => $item,
                'items_forms' => 'SIAC.domicilio.calle.__calle.__calle_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'user'        => $user,

            ]
        );
    }

// ***************** GUARDA LOS CAMBIOS ++++++++++++++++++++ //
    protected function updateItem(CalleRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listCalles');
    }

    protected function updateItemV2(CalleRequest $request){
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editCalleV2')
                ->withErrors($Obj)
                ->withInput();
        }else{
            $id = $Obj->id;
        }
        return Response::json(['mensaje' => 'Dato agregado con éxito', 'data' => 'OK', 'status' => '200'], 200);
    }


// ***************** MAUTOCOMPLETE DE UBICACIONES ++++++++++++++++++++ //
    protected function buscarCalle(Request $request)
    {
        ini_set('max_execution_time', 300000);
        //$filters =$request->input('search');
        $filters = $request->all(['search']);
        //dd($filters);
        //$F           = new FuncionesController();
        //$tsString    = $F->string_to_tsQuery( strtoupper($filters),' & ');

        $search = $filters['search'];
        $items = Calle::query()
            ->search($search)
            ->orderBy('id')
            ->get();

//        ->filterBy($filters)

        //dd($items);

        $data=array();

        foreach ($items as $item) {
            $data[]=array('value'=>$item->calle,'id'=>$item->id);
        }
        if(count($data))
            return $data;
        else
            return ['value'=>'No se encontraron calles','id'=>0];

    }

// ***************** MAUTOCOMPLETE DE UBICACIONES ++++++++++++++++++++ //
    protected function getCalle($IdCalle=0)
    {
        $items = Calle::find($IdCalle);
        return Response::json(['mensaje' => 'OK', 'data' => json_decode($items), 'status' => '200'], 200);

    }









// ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
    protected function removeItem($id = 0)
    {
        $item = Calle::withTrashed()->findOrFail($id);
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
