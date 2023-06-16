<?php

namespace App\Http\Controllers\Catalogos\Dependencia;

use App\Classes\RemoveItemSafe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dependencia\SubareaRequest;
use App\Models\Catalogos\Subarea;
use App\Models\Catalogos\Area;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class SubareaController extends Controller
{
    protected $tableName = "subareas";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Subarea::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('catalogos.catalogo.dependencias.subarea.subarea_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => ' ',
                'user'            => $user,
                'searchInList'    => 'listSubareas',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editSubareaV2',
                'newItem'         => 'newSubareaV2',
                'removeItem'      => 'removeSubarea',
                'IsModal'         => true,
                'exportModel'     => 5,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItem()
    {
        $Jefes = User::query()->whereHas('roles',function($q){
                    return $q->where('name','JEFE');
                })->orderByRaw("concat(ap_paterno,' ',ap_materno,' ',nombre) DESC")
                ->get();
        $Areas = Area::all(['id','area','dependencia_id'])->sortBy('area');
        return view('catalogos.catalogo.dependencias.subarea.subarea_new',
            [
                'editItemTitle'   => 'Nuevo',
                'jefes'           => $Jefes,
                'area'            => $Areas,
                'postNew'         => 'createSubarea',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro ',
            ]
        );
    }

    protected function createItem(SubareaRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listSubareas');
    }

    // ***************** CREAR NUEVO MODAL ++++++++++++++++++++ //
    protected function newItemV2()
    {
        $Jefes = User::query()->whereHas('roles',function($q){
                    return $q->where('name','JEFE');
                })->orderByRaw("concat(ap_paterno,' ',ap_materno,' ',nombre) DESC")
                ->get();
        $Areas = Area::all(['id','area','dependencia_id'])->sortBy('area');
        $user = Auth::user();
        return view('SIAC.dependencia.subarea.subarea_modal',
            [
                'Titulo'          => 'Nueva',
                'Route'           => 'createSubareaV2',
                'Method'          => 'POST',
                'items_forms'     => 'SIAC.dependencia.subarea.__subarea.__subarea_new',
                'IsNew'           => true,
                'user'            => $user,
                'jefes'           => $Jefes,
                'area'            => $Areas,
            ]
        );

    }

    protected function createItemV2(SubareaRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newSubareaV2')
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
        $item = Subarea::find($Id);
        $Jefes = User::query()->whereHas('roles',function($q){
                    return $q->where('name','JEFE');
                })->orderByRaw("concat(ap_paterno,' ',ap_materno,' ',nombre) DESC")
                ->get();
        $Areas = Area::all(['id','area','dependencia_id'])->sortBy('area');
//        dd($Areas);
        return view('catalogos.catalogo.dependencias.subarea.subarea_edit',
            [
                'user' => Auth::user(),
                'jefes' => $Jefes,
                'area' => $Areas,
                'items' => $item,
                'editItemTitle' => isset($item->subarea) ? $item->subarea : 'Nuevo',
                'putEdit' => 'updateSubarea',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(SubareaRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listSubareas');
    }

// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Subarea::find($Id);
        $Jefes = User::query()->whereHas('roles',function($q){
                    return $q->where('name','JEFE');
                })->orderByRaw("concat(ap_paterno,' ',ap_materno,' ',nombre) DESC")
                ->get();
        $Areas = Area::all(['id','area','dependencia_id'])->sortBy('area');
//        dd($Areas);
        $user = Auth::user();
        return view('SIAC.dependencia.subarea.subarea_modal',
            [
                'Titulo'          => isset($item->subarea) ? $item->subarea : 'Nueva',
                'Route'           => 'updateSubareaV2',
                'Method'          => 'POST',
                'items_forms'     => 'SIAC.dependencia.subarea.__subarea.__subarea_edit',
                'IsNew'           => false,
                'IsModal'         => true,
                'items'           => $item,
                'user'            => $user,
                'jefes'           => $Jefes,
                'area'            => $Areas,
            ]
        );

    }

    protected function updateItemV2(SubareaRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = $request->all(['id']);
            $redirect = 'editSubareaV2/' . $id;
            return redirect($redirect)
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
        $item = Subarea::withTrashed()->findOrFail($id);
        if (isset($item)) {
//            if (!$item->trashed()) {
//                $item->forceDelete();
//            } else {
//                $item->forceDelete();
//            }
//            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
            return RemoveItemSafe::RemoveItemObject($item,'subarea_id',$id);

        } else {
            return Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
        }
    }


}
