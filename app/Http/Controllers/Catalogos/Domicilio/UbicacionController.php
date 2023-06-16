<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Models\Catalogos\Domicilios\Calle;
use App\Models\Catalogos\Domicilios\Ciudad;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Estado;
use App\Models\Catalogos\Domicilios\Localidad;
use App\Models\Catalogos\Domicilios\Municipio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\Domicilios\Codigopostal;
use App\Http\Requests\Domicilio\UbicacionRequest;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Domicilios\Comunidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class UbicacionController extends Controller
{


    protected $tableName = "ubicaciones";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $items = Ubicacion::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate();
        $items->appends($filters)->fragment('table');
        $user = Auth::User();

        return view('catalogos.catalogo.domicilio.ubicacion.ubicacion_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listUbicaciones',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editUbicacion',
                'newItem'         => 'newUbicacion',
                'removeItem'      => 'removeUbicacion',
                'exportModel'     => 1,
            ]
        );
    }

// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItem($Id){
        $item            = Ubicacion::find($Id);
//        dd($item);
        $Calles          = Calle::all()->sortBy('calle')->pluck('calle','id');
        $Colonias        = Colonia::all()->sortBy('colonia')->pluck('colonia','id');
        $Comunidades     = Comunidad::all()->sortBy('comunidad')->pluck('comunidad','id');
        $Codigospostales = Codigopostal::all()->sortBy('cp')->pluck('cp','id');

        return view('catalogos.catalogo.domicilio.ubicacion.ubicacion_edit',
            [
                'user' => Auth::user(),
                'calles'          => $Calles,
                'colonias'        => $Colonias,
                'comunidades'     => $Comunidades,
                'codigospostales' => $Codigospostales,
                'items'           => $item,
                'editItemTitle'   => isset($item->ubicacion) ? $item->ubicacion : 'Nuevo',
                'putEdit'         => 'updateUbicacion',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

// ***************** GUARDA LOS CAMBIOS ++++++++++++++++++++ //
    protected function updateItem(UbicacionRequest $request)
    {
        $item = $request->manage();
        if (!isset($item->id)) {
            abort(405);
        }
        return Redirect::to('listUbicaciones');
    }

    protected function updateItemV2(UbicacionRequest $request)
    {
        $item = $request->manage();
        if (!isset($item->id)) {
            abort(405);
        }
        return Redirect::to('editUbicacion',['Id'=>$request->all('id')]);
    }

    protected function newItem()
    {
        $Calles          = Calle::all()->sortBy('calle');
        $Colonias        = Colonia::all()->sortBy('colonia');
        $Comunidades     = Comunidad::all()->sortBy('comunidad');
        $Codigospostales = Codigopostal::all()->sortBy('cp');
        return view('catalogos.catalogo.domicilio.ubicacion.ubicacion_new',
            [
                'editItemTitle'   => 'Nuevo',
                'calles'          => $Calles,
                'colonias'        => $Colonias,
                'comunidades'     => $Comunidades,
                'codigospostales' => $Codigospostales,
                'postNew'         => 'createUbicacion',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro',
            ]
        );
    }

    protected function newItemV2()
    {
        $Calles          = Calle::all()->sortBy('calle');
        $Colonias        = Colonia::all()->sortBy('colonia');
        $Comunidades     = Comunidad::all()->sortBy('comunidad');
        $Codigospostales = Codigopostal::all()->sortBy('cp');
        $user            = Auth::user();

        return view('SIAC.domicilio.ubicacion.ubicacion_new',
            [
                'calles'          => $Calles,
                'colonias'        => $Colonias,
                'comunidades'     => $Comunidades,
                'codigospostales' => $Codigospostales,
                'Method'          => 'POST',
                'Route'           => 'createUbicacionV2',
                'items_forms'     => 'SIAC.domicilio.ubicacion.__ubicacion.__ubicacion_new',
                'IsNew'           => true,
                'user'            => $user,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function createItem(UbicacionRequest $request)
    {
        $item = $request->manage();
        //dd($item);
        if (!isset($item->id)) {
            abort(404);
        }
        return Redirect::to('listUbicaciones');
    }

    protected function createItemV2(UbicacionRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newUbicacionV2')
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
        $item = Ubicacion::withTrashed()->findOrFail($id);
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
