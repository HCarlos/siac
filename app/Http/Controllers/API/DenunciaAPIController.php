<?php

namespace App\Http\Controllers\API;

use App\Events\APIDenunciaEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\DenunciaAddImageAPIRequest;
use App\Http\Requests\API\DenunciaAddRespuestaAPIRequest;
use App\Http\Requests\API\DenunciaAPIRequest;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\_viMovSM;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use App\Models\Denuncias\Imagene;
use App\Models\Denuncias\Respuesta;
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
                    'ubicacion'        => $den->ubicacion_google,
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
            $response["msg"] = " Su respuesta fue agregada correctamente!";
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


    protected function getImagenesFromRoles(int $denuncia_id, int $dependencia_id, int $servicio_id) {
        $imagenes = Imagene::select(['id', 'fecha','image_thumb','momento','denuncia__id','user__id','parent__id']
        )->where("denuncia__id",$denuncia_id)
            ->OrderByDesc("id")
            ->get();
        $imgs = [];
        foreach ($imagenes as $imagen){
            $fecha               = (new Carbon($imagen->fecha))->format('d-m-Y H:i:s');
            $path = "/storage/denuncia/";
            $imgs[] = [
                "fecha"          => $fecha,
                "url_thumb"      => config("atemun.public_url").$path.$imagen->image_thumb,
            ];
        }
        return $imgs;
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

    protected function getRespuestasFromRoles(int $denuncia_id, int $dependencia_id, int $servicio_id) {
        $respuestas = Denuncia_Dependencia_Servicio::select(['id',
            'denuncia_id','dependencia_id','servicio_id','estatu_id','fecha_movimiento',
            'observaciones','favorable','fue_leida','creadopor_id',])
            ->where("denuncia_id",$denuncia_id)
            ->OrderByDesc("id")
            ->get();
        foreach ($respuestas as $r){
            $fecha_movimiento = (new Carbon($r->fecha_movimiento))->format('d-m-Y H:i:s');
            $resp['denuncia_id']      = $r->denuncia_id;
            $resp['dependencia_id']   = $r->dependencia_id;
            $resp['servicio_id']      = $r->servicio_id;
            $resp['estatu_id']        = $r->estatu_id;
            $resp['fecha_movimiento'] = $fecha_movimiento;
            $resp['observaciones']    = trim($r->observaciones);
            $resp['favorable']        = $r->favorable;
            $resp['fue_leida']        = $r->fue_leida;
            $resp['creadopor_id']     = $r->creadopor_id;
        }
        return $respuestas;
    }





    public function getDenunciasForRole(Request $request): JsonResponse{
        $response = ["status"=>0, "msg"=>""];
        $data = (object) $request->all();
        $user_id = $data->user_id;

        $user = User::find($user_id);
        $deps = $user->dependencia_id_array;

        $dens = _viMovSM::query()
            ->where("fecha_ingreso",'>','2025-11-18')
            ->whereIn("dependencia_id",$deps)
            ->where("estatu_id",19)
            ->OrderByDesc("denuncia_id")
            ->get();
        if ($dens){
            $response["status"] = 1;
            $response["msg"] = "OK";
            $denucias = array();
            foreach ($dens as $den){

                $fecha_ingreso = (new Carbon($den->fecha_ingreso))->format('d-m-Y H:i:s');
                $fecha_ultimo_estatus = (new Carbon($den->fecha_ultimo_estatus))->format('d-m-Y H:i:s');
                $sue      = Servicio::find($den->sue_id);
                $ue      = Estatu::find($den->ue_id);
                $d = [
                    'solicitud_id'               => $den->denuncia_id,
                    'fecha_ingreso'              => $fecha_ingreso,
                    'fecha_ultimo_estatus'       => $fecha_ultimo_estatus,
                    'denuncia'                   => $den->descripcion,
                    'dependencia_id'             => $den->dependencia_id,
                    'dependencia'                => $den->dependencia,
                    'servicio_id'                => $den->servicio_id,
                    'servicio'                   => $den->servicio,
                    'servicio_ultimo_estatus_id' => $den->sue_id,
                    'servicio_ultimo_estatus'    => $sue->servicio,
                    'ultimo_estatus_id'          => $den->ue_id,
                    'ultimo_estatus'             => $ue->estatus,
                    'origen_id'                  => $den->origen_id,
                    'origen'                     => $den->origen,
                    'latitud'                    => $den->latitud,
                    'longitud'                   => $den->longitud,
                    'observaciones'              => $den->observaciones,
                    'imagenes'                   => $this->getImagenesFromRoles($den->denuncia_id,$den->dependencia_id,$den->servicio_id),
                    'respuestas'                 => $this->getRespuestasFromRoles($den->denuncia_id,$den->dependencia_id,$den->servicio_id),
                ];
                $denucias[] = $d;
            }
            $response["solicitudes"] = $denucias;
        }
        return response()->json($response);

    }




}
