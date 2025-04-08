<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Operador;
use App\Models\Denuncias\Imagene;
use App\Models\Denuncias\Respuesta;
use App\Models\Mobiles\Imagemobile;
use App\Models\Mobiles\Respuestamobile;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OperadoresAPIController extends Controller{



    public function getSolicitudesOperador(Request $request): JsonResponse{
        $response = ["status"=>0, "msg"=>""];
        $data = (object) $request->all();
        $user_id = $data->user_id;

        $items = Denuncia_Operador::select('denuncia_id')
            ->where('operador_id', (int) $user_id )
            ->orderBy('id')
            ->get()
            ->pluck('denuncia_id')
            ->toArray();

//        dd($items);

        $dens = Denuncia::select(FuncionesController::itemSelectDenuncias())
            ->whereIn("id",$items)
            ->OrderByDesc("id")
            ->get();

//        dd($dens);

        if ($dens){
            $response["status"] = 1;
            $response["msg"] = "OK";
            $denucias = array();
            foreach ($dens as $den){

                $Ser = Servicio::find($den->sue_id);

                $fecha = (new Carbon($den->fecha))->format('d-m-Y H:i:s');
                $d = [
                    'id'               => $den->id,
                    'denuncia'         => $den->descripcion,
                    'fecha'            => $fecha,
                    'latitud'          => $den->latitud,
                    'longitud'         => $den->longitud,
                    'ubicacion'        => $den->full_ubication,
                    'ubicacion_google' => $den->gd_ubicacion,
                    'servicio'         => $Ser->servicio,
                    'imagenes'         => $this->getImagenes($den->id),
                    'respuestas'       => $this->getRespuestas($den->id),
                ];
                $denucias[] = $d;
            }
            $response["denuncias"] = $denucias;
        }
        return response()->json($response);

    }

    protected function getImagenes(int $denuncia_id) {
        $imagenes = Imagene::select(['id', 'fecha','root','image','image_thumb','titulo','descripcion','momento','denuncia__id','user__id','parent__id'])
            ->where("denuncia__id",$denuncia_id)
            ->OrderByDesc("id")
            ->get();
        foreach ($imagenes as $imagen){
            $path = "/storage/denuncia/";
            $fecha                 = (new Carbon($imagen->fecha))->format('d-m-Y H:i:s');
            $imagen['fecha']       = $fecha;
            $imagen["image"]       = config("atemun.public_url").$path.$imagen->image;
            $imagen["image_thumb"] = config("atemun.public_url").$path.$imagen->image_thumb;
            $imagen["momento"]     = $imagen->momento;
            $imagen["titulo"]      = $imagen->titulo;
            $imagen["descripcion"] = $imagen->momento;
        }
        return $imagenes;
    }


    // Obtenemos sus respuestas
    protected function getRespuestas(int $denuncia_id) {
        $respuestas = Respuesta::select(['id', 'fecha','respuesta','observaciones','denuncia__id','user__id','parent__id'])
            ->where("denuncia__id",$denuncia_id)
            ->OrderBy("id")
            ->get();
        foreach ($respuestas as $resp){
            $fecha                 = (new Carbon($resp->fecha))->format('d-m-Y H:i:s');
            $resp['fecha']         = $fecha;
            $user = User::find($resp->user__id);
            if( $user->isRole('Administrator') )
                $resp['roleuser'] = "Administrator";
            else
                $resp['roleuser'] = $user->roles->first()->name;
            $resp['username'] = $user->ap_paterno.' '.$user->nombre;
        }
        return $respuestas;
    }




}
