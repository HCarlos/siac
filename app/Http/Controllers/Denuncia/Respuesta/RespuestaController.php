<?php

namespace App\Http\Controllers\Denuncia\Respuesta;

use App\Http\Controllers\Controller;
use App\Http\Requests\Denuncia\Respuesta\RespuestaRequest;
use App\Http\Requests\Denuncia\Respuesta\RespuestARespuestaRequest;
use App\Models\Denuncias\Respuesta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RespuestaController extends Controller
{

//************************************************************************************
//************             R   E   S   P   U   E   S   T   A   S                    ***
//***************************************************************+++++++++++++++++++**

    protected $tableName = "respuestas";

    // Obtiene el Listado de Respuestas
    protected function index($Id)
    {

        $items = Respuesta::select()
            ->whereHas('denuncias', function ($q) use ($Id) {
                return $q->where('denuncia_id',$Id)
                    ->where('parent__id',0);
            })
            ->orderByDesc('id')
            ->orderBy('parent__id')
            ->paginate();

        // dd($items);

        $user = Auth::User();


        return view('SIAC.denuncia.respuesta.respuesta_list',
            [
                'items' => $items,
                'titulo_catalogo' => ucwords($this->tableName).' de la denuncia: '.$Id,
                'titulo_header'   => '',
                'user' => $user,
                'searchInListRespuesta' => 'listRespuestas',
                'newWindow' => true,
                'tableName' => $this->tableName,
                'newItem' => '/showModalRespuestaNew',
                'editItem' => '/showModalRespuestaEdit',
                'showEdit' => 'editDenuncia',
                'denuncia_id' => $Id,
                'removeItem' => 'removeRespuesta',
                'findDataInRespuesta'=>'findDataInRespuesta',
                'exportModel' => 21,
                'new2Item' => '/RespuestaARespuestaNew',
                'RespuestaARespuestaNew' => '/RespuestaARespuestaNew',
                'RespuestaARespuestaEdit' => '/RespuestaARespuestaEdit',
            ]
        );

    }

// ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
    protected function removeItem($id = 0)
    {
        $item = Respuesta::withTrashed()->findOrFail($id);
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

    protected function showModalRespuestaNew($denuncia_id){
        $user = Auth::user();

        return view ('SIAC.denuncia.respuesta.respuesta_new_modal',
            [
                'Route'       => 'saveRespuestaDen',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.denuncia.respuesta.__respuesta.__respuesta_new',
                'IsNew'       => true,
                'denuncia_id' => $denuncia_id,
                'user'        => $user,
            ]
        );
    }

    protected function showModalRespuestaEdit($Id){
        $user = Auth::user();
        $resp = Respuesta::find($Id);
        //dd($resp);
        return view ('SIAC.denuncia.respuesta.respuesta_edit_modal',
            [
                'Route'           => 'saveRespuestaDen',
                'Method'          => 'PUT',
                'items_forms'     => 'SIAC.denuncia.respuesta.__respuesta.__respuesta_edit',
                'IsNew'           => false,
                'id'              => $Id,
                'denuncia_id'     => $resp->denuncia->id,
                'user'            => $user,
                'items'           => $resp,
            ]
        );
    }

    protected function saveRespuestaDen(RespuestaRequest $request){
        $item = $request->manage();
        if (isset($item)){
            return Response::json(['mensaje' => 'Información guardada con éxito!', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'Hubo un error!', 'data' => $item, 'status' => '422'], 200);
        }
    }


// RESPUESTA A RESPUESTA

    protected function RespuestaARespuestaNew($denuncia_id,$respuesta_id){
        $user = Auth::user();

        return view ('SIAC.denuncia.respuesta_a_respuesta.respuesta_a_respuesta_new_modal',
            [
                'Route'           => 'saveRespuestaARespuestaDen',
                'Method'          => 'PUT',
                'items_forms'     => 'SIAC.denuncia.respuesta_a_respuesta.__respuesta_a_respuesta.__respuesta_a_respuesta_new',
                'IsNew'           => true,
                'denuncia_id'     => $denuncia_id,
                'respuesta_id'    => $respuesta_id,
                'user'            => $user,

            ]
        );
    }

    protected function saveRespuestaARespuestaDen(RespuestARespuestaRequest $request){
        $item = $request->manage();
        if (isset($item)){
            return Response::json(['mensaje' => 'Información guardada con éxito!', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'Hubo un error!', 'data' => $item, 'status' => '422'], 200);
        }
    }










}
