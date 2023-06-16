<?php

namespace App\Http\Controllers\Catalogos\Dependencia;

use App\Classes\RemoveItemSafe;
use App\Http\Requests\Dependencia\AreaRequest;
use App\Models\Catalogos\Area;
use App\Models\Catalogos\Dependencia;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class AreaController extends Controller
{
    protected $tableName = "Áreas";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Area::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate(10000);
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('catalogos.catalogo.dependencias.area.area_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => ' ',
                'user'            => $user,
                'searchInList'    => 'listAreas',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editAreaV2',
                'newItem'         => 'newAreaV2',
                'removeItem'      => 'removeArea',
                'IsModal'         => true,
                'exportModel'     => 4,
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
        $Dependencias = Dependencia::select('id','dependencia')
            ->orderBy('dependencia')
            ->get();
        return view('catalogos.catalogo.dependencias.area.area_new',
            [
                'editItemTitle' => 'Nuevo',
                'jefes' => $Jefes,
                'dependencia' => $Dependencias,
                'postNew' => 'createArea',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro ',
            ]
        );
    }

    protected function createItem(AreaRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listAreas');
    }


    // ***************** CREAR NUEVO MODAL ++++++++++++++++++++ //
    protected function newItemV2()
    {
        $Jefes = User::query()->whereHas('roles',function($q){
                return $q->where('name','JEFE');
            })->orderByRaw("concat(ap_paterno,' ',ap_materno,' ',nombre) DESC")
            ->get();
        $Dependencias = Dependencia::select('id','dependencia')
            ->orderBy('dependencia')
            ->get();
        $user = Auth::user();
        return view('SIAC.dependencia.area.area_modal',
            [
                'Titulo'          => 'Nueva',
                'Route'           => 'createAreaV2',
                'Method'          => 'POST',
                'items_forms'     => 'SIAC.dependencia.area.__area.__area_new',
                'IsNew'           => true,
                'user'            => $user,
                'jefes'           => $Jefes,
                'dependencia'     => $Dependencias,
            ]
        );


    }

    protected function createItemV2(AreaRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newAreaV2')
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
        $item = Area::find($Id);
        $Jefes = User::query()->whereHas('roles',function($q){
                    return $q->where('name','JEFE');
                })->orderByRaw("concat(ap_paterno,' ',ap_materno,' ',nombre) DESC")
                ->get();
        $Dependencias = Dependencia::select('id','dependencia')
            ->orderBy('dependencia')
            ->get();

        return view('catalogos.catalogo.dependencias.area.area_edit',
            [
                'user' => Auth::user(),
                'jefes' => $Jefes,
                'dependencia' => $Dependencias,
                'items' => $item,
                'editItemTitle' => isset($item->area) ? $item->area : 'Nuevo',
                'putEdit' => 'updateArea',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(AreaRequest $request)
    {
        $item = $request->manage();
        if (!isset($item)) {
            abort(404);
        }
        return Redirect::to('listAreas');
    }

// ***************** EDITA LOS DATOS MODAL  ++++++++++++++++++++ //
    protected function editItemV2($Id)
    {
        $item = Area::find($Id);
        $Jefes = User::query()->whereHas('roles',function($q){
                    return $q->where('name','JEFE');
                })->orderByRaw("concat(ap_paterno,' ',ap_materno,' ',nombre) DESC")
                ->get();
        $Dependencias = Dependencia::select('id','dependencia')
            ->orderBy('dependencia')
            ->get();

        $user = Auth::user();
        return view('SIAC.dependencia.area.area_modal',
            [
                'Titulo'          => isset($item->area) ? $item->area : 'Nueva',
                'Route'           => 'updateAreaV2',
                'Method'          => 'POST',
                'items_forms'     => 'SIAC.dependencia.area.__area.__area_edit',
                'IsNew'           => false,
                'IsModal'         => true,
                'items'           => $item,
                'user'            => $user,
                'jefes'           => $Jefes,
                'dependencia'     => $Dependencias,
            ]
        );

    }

    protected function updateItemV2(AreaRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = $request->all(['id']);
            $redirect = 'editAreaV2/' . $id;
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
        $item = Area::withTrashed()->findOrFail($id);
        if (isset($item)) {

//            if (!$item->trashed()) {
//                $item->forceDelete();
//            } else {
//                $item->forceDelete();
//            }
//            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
            return RemoveItemSafe::RemoveItemObject($item,'area_id',$id);

        } else {
            return Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
        }
    }



}
