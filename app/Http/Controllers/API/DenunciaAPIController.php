<?php

namespace App\Http\Controllers\API;

use App\Events\APIDenunciaEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\DenunciaAddImageAPIRequest;
use App\Http\Requests\API\DenunciaAddRespuestaAPIRequest;
use App\Http\Requests\API\DenunciaAPIRequest;
use App\Models\Mobiles\Denunciamobile;
use App\Models\Mobiles\Imagemobile;
use App\Models\Mobiles\Respuestamobile;
use App\Models\Mobiles\Serviciomobile;
use App\Models\Users\UserMobile;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DenunciaAPIController extends Controller{

    public function insertDenunciaMobile(DenunciaAPIRequest $request):JsonResponse {
        $response = ["status"=>0, "msg"=>""];
        $den = (object)  $request->manage();
        if ( isset($den->id) ){
            $response["status"] = 1;
            $response["msg"] = "Solicitud de servicio enviada con éxito!";
            if ( isset($data->deviceToken) && isset($data->device_name) ){
                if ( ! UserMobile::query()
                    ->where('user_id',$den->user_id)
                    ->where('token',$data->deviceToken)
                    ->where('mobile_type',$data->device_name)
                    ->first() ) {

                    UserMobile::create([
                        'user_id' => $den->user_id,
                        'token' => $data->deviceToken,
                        'mobile_type' => $data->device_name
                    ]);

                }
            }
            event(new APIDenunciaEvent($den->id, $den->user_id));
        }else{
            $response = $den;
        }
        return response()->json($response);
    }

    public function getDenuncias(Request $request): JsonResponse{
        $response = ["status"=>0, "msg"=>""];
        $data = (object) $request->all();
        $user_id = $data->user_id;

        $dens = Denunciamobile::select(['id','denuncia','fecha','latitud','longitud','ubicacion','ubicacion_google','user_id','serviciomobile_id'])
            ->where("user_id",$user_id)
            ->OrderByDesc("id")
            ->get();
        if ($dens){
            $response["status"] = 1;
            $response["msg"] = "OK";
            $denucias = array();
            foreach ($dens as $den){

                $Ser = Serviciomobile::find($den->serviciomobile_id);

                $fecha = (new Carbon($den->fecha))->format('d-m-Y H:i:s');
                $d = [
                    'id'               => $den->id,
                    'denuncia'         => $den->denuncia,
                    'fecha'            => $fecha,
                    'latitud'          => $den->latitud,
                    'longitud'         => $den->longitud,
                    'ubicacion'        => $den->ubicacion,
                    'ubicacion_google' => $den->ubicacion_google,
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

    public function addImageDenunciaMobile(DenunciaAddImageAPIRequest $request):JsonResponse {
        $response = ["status"=>0, "msg"=>"Ha ocurrido un error al subir la imagen"];
        $den = (object)  $request->manage();
        if ($den){
            $response["status"] = 1;
            $response["msg"] = "Su imagen fue agregada correctamente!";
        }
        return response()->json($response);
    }


    public function addRespuestaDenunciaMobile(DenunciaAddRespuestaAPIRequest $request):JsonResponse {
        $response = ["status"=>0, "msg"=>"Ha ocurrido un error al subir la respuesta"];
        $den = (object)  $request->manage();
        if ($den){
            $response["status"] = 1;
            $response["msg"] = "Su respuesta fue agregada correctamente!";
        }
        return response()->json($response);
    }

    public function getImagenesFromDenunciaMobile(int $denunciamobile_id):JsonResponse {
        return response()->json($this->getImagenes($denunciamobile_id));
    }

    public function getRespuestasFromDenunciaMobile(int $denunciamobile_id):JsonResponse {
        return response()->json($this->getRespuestas($denunciamobile_id));
    }

    // Obtenemos sus imágenes
    protected function getImagenes(int $denunciamobile_id) {
        $imagenes = Imagemobile::select(['id','fecha','filename','filename_png','filename_thumb','user_id','denunciamobile_id','latitud','longitud']
        )->where("denunciamobile_id",$denunciamobile_id)
            ->OrderByDesc("id")
            ->get();
        foreach ($imagenes as $imagen){
            $fecha               = (new Carbon($imagen->fecha))->format('d-m-Y H:i:s');
            $path = "/storage/mobile/denuncia/";
            $imagen['fecha']     = $fecha;
            $imagen["url"]       = config("atemun.public_url").$path.$imagen->filename;
            $imagen["url_png"]   = config("atemun.public_url").$path.$imagen->filename_png;
            $imagen["url_thumb"] = config("atemun.public_url").$path.$imagen->filename_thumb;
        }
        return $imagenes;
    }


    // Obtenemos sus respuestas
    protected function getRespuestas(int $denunciamobile_id) {
        $respuestas = Respuestamobile::select(['id','fecha','respuesta','observaciones', 'user_id'])
            ->where("denunciamobile_id",$denunciamobile_id)
            ->OrderBy("id")
            ->get();
        foreach ($respuestas as $resp){
            $fecha                 = (new Carbon($resp->fecha))->format('d-m-Y H:i:s');
            $resp['fecha']         = $fecha;
            $user = User::find($resp->user_id);
            if( $user->isRole('Administrator') )
                $resp['roleuser'] = "Administrator";
            else
                $resp['roleuser'] = $user->roles->first()->name;
            $resp['username'] = $user->ap_paterno.' '.$user->nombre;
        }
        return $respuestas;
    }





}
