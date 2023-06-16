<?php

namespace App\Http\Controllers\Denuncia;

use App\Classes\RemoveItemSafe;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Requests\Denuncia\ServicioRequest;
use App\Models\Catalogos\Medida;
use App\Models\Catalogos\Servicio;
use App\Models\Catalogos\Subarea;
use App\Models\Denuncias\_Servicios;
use App\Models\Denuncias\Denuncia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{

    protected $tableName = "Servicios";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);

        $filters = $request->all(['search']);
//        $search = $filters['search'];

//        $filters =$request->input('search');
//        $F           = new FuncionesController();
//        $tsString    = $F->string_to_tsQuery( strtoupper($filters),' & ');
//        dd($filters);


        $items = _Servicios::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');

//          $items = DB::table('_viservicios')
//            ->filterBy($filters)
//            ->orderByDesc('id')
//            ->paginate(10000);
//        $items->appends($filters)->fragment('table');

        $user = Auth::User();

//        ->filterBy($filters)
//        ->search($tsString)

//        dd($items);

        return view('SIAC.estructura.servicio.servicio_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listServicios',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editServicio',
                'newItem'         => 'newServicio',
                'removeItem'      => 'removeServicio',
                'IsModal'         => false,
                'exportModel'     => 2,
            ]
        );
    }


    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItem()
    {
        $medidas = Medida::all(['id','medida'])->sortBy('medida');
        $subareas = Subarea::all()->sortBy('subarea');
        return view('SIAC.estructura.servicio.servicio_new',
            [
                'editItemTitle' => 'Nuevo',
                'postNew' => 'createServicio',
                'medidas' => $medidas,
                'subareas' => $subareas,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro',
            ]
        );
    }

    protected function createItem(ServicioRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listServicios');
    }


    // ***************** CREAR NUEVO MODAL ++++++++++++++++++++ //
    protected function newItemV2()
    {
        $medidas = Medida::all(['id','medida'])->sortBy('medida');
        $subareas = Subarea::all()->sortBy('subarea');
        $user = Auth::user();
        return view('SIAC.estructura.servicio.servicio_new',
            [
                'Titulo'      => 'Nuevo',
                'Route'       => 'createServicioV2',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.estructura.servicio.__servicio.__servicio_new',
                'IsNew'       => true,
                'user'        => $user,
                'medidas'     => $medidas,
                'subareas'    => $subareas,
            ]
        );
    }

    protected function createItemV2(ServicioRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newServicioV2')
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
        $item = Servicio::find($Id);
        $medidas = Medida::all(['id','medida'])->sortBy('medida');
        $subareas = Subarea::all()->sortBy('subarea');
        //dd($item);
        return view('SIAC.estructura.servicio.servicio_edit',
            [
                'user' => Auth::user(),
                'items' => $item,
                'medidas' => $medidas,
                'subareas' => $subareas,
                'editItemTitle' => isset($item->categoria) ? $item->categoria : 'Nuevo',
                'putEdit' => 'updateServicio',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio : '.$Id,
            ]
        );
    }

    protected function updateItem(ServicioRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listServicios');
    }


// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Servicio::find($Id);
        $medidas = Medida::all(['id','medida'])->sortBy('medida');
        $subareas = Subarea::all()->sortBy('subarea');
        $user = Auth::user();
        return view('SIAC.estructura.servicio.servicio_modal',
            [
                'Titulo'      => isset($item->prioridad) ? $item->prioridad : 'Nuevo',
                'Route'       => 'updateServicioV2',
                'Method'      => 'POST',
                'items'       => $item,
                'items_forms' => 'SIAC.estructura.servicio.__servicio.__servicio_edit',
                'IsNew'       => false,
                'IsModal'     => true,
                'user'        => $user,
                'medidas'     => $medidas,
                'subareas'    => $subareas,
            ]
        );
    }

    protected function updateItemV2(ServicioRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editServicioV2')
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
        $item = Servicio::withTrashed()->findOrFail($id);
        if (isset($item)) {
            return RemoveItemSafe::RemoveItemObject($item,'servicio_id',$id);
        } else {
            return Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
        }
    }


}
