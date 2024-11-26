<?php

namespace App\Http\Controllers\Denuncia\Respuesta;

use App\Http\Controllers\Controller;
use App\Http\Requests\Denuncia\Respuesta\RespuestaRequest;
use App\Models\Denuncias\Respuesta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RespuestaCiudadanaAmbitoController extends Controller
{

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

        $user = Auth::User();

        return view('denuncia.respuesta_ciudadana.respuesta_ciudadana_list',
            [
                'items' => $items,
                'titulo_catalogo' =>ucwords($this->tableName).' de mi denuncia: '.$Id,
                'titulo_header'   => '',
                'user' => $user,
                'searchInListRespuesta' => 'listRespuestasCiudadanas',
                'newWindow' => true,
                'tableName' => $this->tableName,
                'newItem' => '/showModalRespuestaCiudadanaNew',
                'editItem' => '/showModalRespuestaCiudadanaEdit',
                'showEdit' => 'editDenunciaCiudadana',
                'denuncia_id' => $Id,
                'removeItem' => 'removeRespuestaCiudadana',
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

    protected function showModalRespuestaCiudadanaNew($denuncia_id){
        $user = Auth::user();
        return view ('SIAC.denuncia.respuesta_ciudadana.respuesta_ciudadana_new_modal',
            [
                'Route'       => 'saveRespuestaDen',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.denuncia.respuesta_ciudadana.__respuesta_ciudadana.__respuesta_ciudadana_new',
                'IsNew'       => true,
                'denuncia_id' => $denuncia_id,
                'user'        => $user,
            ]
        );


    }

    protected function showModalRespuestaCiudadanaEdit($Id){
        $user = Auth::user();
        $resp = Respuesta::find($Id);

        return view ('SIAC.denuncia.respuesta_ciudadana.respuesta_ciudadana_edit_modal',
            [
                'Route'           => 'saveRespuestaDen',
                'Method'          => 'PUT',
                'items_forms'     => 'SIAC.denuncia.respuesta_ciudadana.__respuesta_ciudadana.__respuesta_ciudadana_edit',
                'IsNew'           => false,
                'id'              => $Id,
                'denuncia_id'     => $resp->denuncia->id,
                'user'            => $user,
                'item'            => $resp,
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








}
