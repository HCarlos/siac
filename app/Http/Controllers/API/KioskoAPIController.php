<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\CentroLocalidad;
use App\Models\Mobiles\Denunciamobile;
use App\Models\Mobiles\Serviciomobile;
use App\Models\Users\UserMobile;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KioskoAPIController extends Controller{

    protected $ServiciosMonitoreados;

    public function __construct()
    {
        $this->ServiciosMonitoreados = [
            (object)['servicio_id' => 483, 'servicio' => "BACHEO DE VIALIDADES"],
            (object)['servicio_id' => 508, 'servicio' => "DESAZOLVE DE DRENAJE"],
            (object)['servicio_id' => 476, 'servicio' => "FUGA DE AGUA POTABLE"],
            (object)['servicio_id' => 503, 'servicio' => "RECOLECCIÓN DE BASURA"],
            (object)['servicio_id' => 479, 'servicio' => "REPARACIÓN DE ALCANTARILLA"],
            (object)['servicio_id' => 466, 'servicio' => "REPARACIÓN DE LUMINARIAS"],
        ];
    }

    public function userCURPLogin(Request $request):JsonResponse {
        $response = ["status"=>0, "msg"=>""];
        $data = (object) $request->all();

        if (trim($data->username) !== "Admin" && trim($data->username) !== "SysOp") {
            $data->username = strtoupper(trim($data->username));
        }
        $user = User::where("curp",trim($data->username))->first();
        if ($user){
            $token = $user->createToken("devch53");
            $response["status"] = 1;
            $response["access_token"] = $token->plainTextToken;
            $response["token_type"] = 'Bearer';
            $response["msg"] = "Usuario obtenido correctamente";
            $response["user"] = $user;
            $response["api_version"] = "1.2.2";
            $response["app_version"] = "1.5.4";
        }else{
            $response["msg"] = "Usuario no encontrado";
        }
        return response()->json($response);
    }

    public function getLocalidades(Request $request): JsonResponse{
        $response = ["status"=>0, "msg"=>""];
        $data = (object) $request->all();

        $loc = CentroLocalidad::query()
            ->orderBy('prefijo_colonia')
            ->orderBy('colonia')
            ->get();
        $Loc = [];
        foreach ($loc as $l){
            $Loc[] = (object)["centro_localidad_id" => $l->id, "localidad" => $l->ItemColonia()];
        }
        if (count($Loc) > 0){
            $response["status"] = 1;
            $response["msg"] = "OK";
            $response["localidades"] = $Loc;
        }else{
            $response["status"] = 0;
            $response["msg"] = "Error";
            $response["localidades"] = null;
        }
        return response()->json($response);

    }




}
