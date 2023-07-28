<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domicilio\ComunidadRequest;
use App\Models\Catalogos\Domicilios\Ciudad;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Estado;
use App\Models\Catalogos\Domicilios\Municipio;
use App\Models\Catalogos\Domicilios\Tipocomunidad;
use App\Traits\Catalogos\Domicilio\Comunidad\ComunidadTrait;
use App\Traits\Common\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class ComunidadController extends Controller
{
    use ComunidadTrait, CommonTrait;

    protected $tableName = "comunidades";
    protected $max_item_for_query = 1000;

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->all(['search']);
        $search = $filters['search'];
        $items = Comunidad::query()
            ->search($search)
            ->orderByDesc('id')
            ->paginate($this->max_item_for_query);
        $items->appends($filters)->fragment('table');
        $user = Auth::User();
//        ->filterBy($filters)

        return view('SIAC.domicilio.comunidad.comunidad_list',
            [
                'items'           => $items,
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => '',
                'user'            => $user,
                'searchInList'    => 'listComunidades',
                'newWindow'       => true,
                'tableName'       => $this->tableName,
                'showEdit'        => 'editComunidadV2',
                'newItem'         => 'newComunidadV2',
                'removeItem'      => 'removeComunidad',
                'IsModal'         => true,
                'exportModel'     => 12,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function newItem()
    {
        $Ciudades       = Ciudad::all()->sortBy('ciudad');
        $Municipios     = Municipio::all()->sortBy('municipio');
        $Estados        = Estado::all()->sortBy('estado');

        $Ciudad_Id      = Ciudad::all()->where('ciudad',config('atemun.ciudad_default'))->first();
        $Municipio_Id   = Municipio::all()->where('municipio',config('atemun.municipio_default'))->first();
        $Estado_Id      = Estado::all()->where('estado',config('atemun.estado_default'))->first();

        $Delegados = $this->getUserFromRoles('DELEGADO');
        $Tipocomunidades = Tipocomunidad::all(['id','tipocomunidad'])->sortBy('tipocomunidad');
        //dd($Delegados);
        return view('catalogos.catalogo.domicilio.comunidad.comunidad_new',
            [
                'editItemTitle' => 'Nuevo',
                'delegados' => $Delegados,
                'tipocomunidades' => $Tipocomunidades,
                'ciudades' => $Ciudades,
                'municipios' => $Municipios,
                'estados' => $Estados,
                'ciudad_id' => $Ciudad_Id->id,
                'municipio_id' => $Municipio_Id->id,
                'estado_id' => $Estado_Id->id,
                'postNew' => 'createComunidad',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Nuevo registro ',
            ]
        );
    }

    protected function createItem(ComunidadRequest $request)
    {
        $item = $request->manage();
        if (!isset($item->id)) {
            abort(404);
        }
        return Redirect::to('listComunidades');
    }

    // ***************** CREAR NUEVO MODAL++++++++++++++++++++ //
    protected function newItemV2()
    {
        $Ciudades        = Ciudad::all()->sortBy('ciudad');
        $Municipios      = Municipio::all()->sortBy('municipio');
        $Estados         = Estado::all()->sortBy('estado');

        $Ciudad_Id       = Ciudad::all()->where('ciudad',config('atemun.ciudad_default'))->first();
        $Municipio_Id    = Municipio::all()->where('municipio',config('atemun.municipio_default'))->first();
        $Estado_Id       = Estado::all()->where('estado',config('atemun.estado_default'))->first();

        $Delegados       = $this->getUserFromRoles('DELEGADO');
        $Tipocomunidades = Tipocomunidad::all(['id','tipocomunidad'])->sortBy('tipocomunidad');

        // dd($Estado_Id->id);

        $user = Auth::user();
        return view('SIAC.domicilio.comunidad.comunidad_modal',
            [
                'Titulo'          => 'Nueva',
                'Route'           => 'createComunidadV2',
                'Method'          => 'POST',
                'items_forms'     => 'SIAC.domicilio.comunidad.__comunidad.__comunidad_new',
                'IsNew'           => true,
                'user'            => $user,
                'delegados'       => $Delegados,
                'tipocomunidades' => $Tipocomunidades,
                'ciudades'        => $Ciudades,
                'municipios'      => $Municipios,
                'estados'         => $Estados,
                'ciudad_id'       => $Ciudad_Id->id,
                'municipio_id'    => $Municipio_Id->id,
                'estado_id'       => $Estado_Id->id,
            ]
        );

    }

    protected function createItemV2(ComunidadRequest $request)
    {
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newComunidadV2')
                ->withErrors($Obj)
                ->withInput();
        }else{
            $id = $Obj->id;
        }
        return Response::json(['mensaje' => 'Dato agregado con éxito', 'data' => 'OK', 'status' => '200'], 200);
    }


// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItem($Id){

        $item            = Comunidad::find($Id);
        $Ciudades        = Ciudad::all()->sortBy('ciudad');
        $Municipios      = Municipio::all()->sortBy('municipio');
        $Estados         = Estado::all()->sortBy('estado');

        $Ciudad_Id       = Ciudad::all()->where('ciudad',config('atemun.ciudad_default'))->first();
        $Municipio_Id    = Municipio::all()->where('municipio',config('atemun.municipio_default'))->first();
        $Estado_Id       = Estado::all()->where('estado',config('atemun.estado_default'))->first();

        $Delegados       = $this->getUserFromRoles('DELEGADO');
        $Tipocomunidades = Tipocomunidad::all(['id','tipocomunidad'])->sortBy('tipocomunidad');

        return view('catalogos.catalogo.domicilio.comunidad.comunidad_edit',
            [
                'user' => Auth::user(),
                'delegados' => $Delegados,
                'tipocomunidades' => $Tipocomunidades,
                'ciudades' => $Ciudades,
                'municipios' => $Municipios,
                'estados' => $Estados,
                'ciudad_id' => $Ciudad_Id->id,
                'municipio_id' => $Municipio_Id->id,
                'estado_id' => $Estado_Id->id,
                'items' => $item,
                'editItemTitle' => isset($item->comunidad) ? $item->comunidad : 'Nuevo',
                'putEdit' => 'updateComunidad',
                'titulo_catalogo' => "Catálogo de " . ucwords($this->tableName),
                'titulo_header'   => 'Editando el Folio '.$Id,
            ]
        );
    }

    protected function updateItem(ComunidadRequest $request)
    {
        $item = $request->manage();
        if (!isset($item->id)) {
            abort(404);
        }
        return Redirect::to('listComunidades');
    }


// ***************** EDITA LOS DATOS  ++++++++++++++++++++ //
    protected function editItemV2($Id){

        $item            = Comunidad::find($Id);
        $Ciudades        = Ciudad::all()->sortBy('ciudad');
        $Municipios      = Municipio::all()->sortBy('municipio');
        $Estados         = Estado::all()->sortBy('estado');

        $Ciudad_Id       = Ciudad::all()->where('ciudad',config('atemun.ciudad_default'))->first();
        $Municipio_Id    = Municipio::all()->where('municipio',config('atemun.municipio_default'))->first();
        $Estado_Id       = Estado::all()->where('estado',config('atemun.estado_default'))->first();

        $Delegados       = $this->getUserFromRoles('DELEGADO');
        $Tipocomunidades = Tipocomunidad::all(['id','tipocomunidad'])->sortBy('tipocomunidad');

        $user = Auth::user();
        return view('SIAC.domicilio.comunidad.comunidad_modal',
            [
                'Titulo'          => 'Nueva',
                'Route'           => 'updateComunidadV2',
                'Method'          => 'POST',
                'items_forms'     => 'SIAC.domicilio.comunidad.__comunidad.__comunidad_edit',
                'IsNew'           => false,
                'IsModal'         => true,
                'items'           => $item,
                'user'            => $user,
                'delegados'       => $Delegados,
                'tipocomunidades' => $Tipocomunidades,
                'ciudades'        => $Ciudades,
                'municipios'      => $Municipios,
                'estados'         => $Estados,
                'ciudad_id'       => $Ciudad_Id->id,
                'municipio_id'    => $Municipio_Id->id,
                'estado_id'       => $Estado_Id->id,
            ]
        );
    }

    protected function updateItemV2(ComunidadRequest $request){
        $Obj = $request->manage();
        if (!is_object($Obj)) {
            $id = $request->all(['id']);
            $redirect = 'editComunidadV2/' . $id;
            return redirect($redirect)
                ->withErrors($Obj)
                ->withInput();
        }else{
            $id = $Obj->id;
        }
        return Response::json(['mensaje' => 'Dato agregado con éxito', 'data' => 'OK', 'status' => '200'], 200);
    }






// ***************** MAUTOCOMPLETE DE UBICACIONES ++++++++++++++++++++ //
    protected function buscarComunidad(Request $request){
        ini_set('max_execution_time', 300000);
        $filters = $request->all(['search']);
        $search = $filters['search'];
        $items = Comunidad::query()
            ->search($search)
            ->orderBy('id')
            ->get();

        $data=array();

        foreach ($items as $item) {
            $data[]=array('value'=>$item->comunidad,'id'=>$item->id, 'is_unificadora' => $item->is_unificadora);
        }
        if(count($data))
            return $data;
        else
            return ['value'=>'No se encontraron datos','id'=>0];

    }

// ***************** MAUTOCOMPLETE DE UBICACIONES ++++++++++++++++++++ //
    protected function getComunidad($IdComunidad=0)
    {
        $items = Comunidad::find($IdComunidad);
        return Response::json(['mensaje' => 'OK', 'data' => json_decode($items), 'status' => '200'], 200);

    }





// ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
    protected function removeItem($id = 0){

        $item = Comunidad::withTrashed()->findOrFail($id);
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
