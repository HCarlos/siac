<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Users\UserMobile;
use App\User;
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

//        if ( !in_array($data->username, $this->usuarios_permitidos, true)) {
//            $response["msg"] = "Acceso denegado!";
//            return response()->json($response);
//        }

        $user = User::where("curp",trim($data->username))->first();
        if ($user){
            $pwd = $user->password;
//            dd($pwd);
//            $pwd2 = strtoupper(trim($pwd));
//            if ( strtoupper(trim($data->username)) === $pwd2  ){
//                $pwd = $pwd2;
//            }
//            if (Hash::check($pwd, $user->password)){
                $token = $user->createToken("devch53");
                $response["status"] = 1;
                $response["access_token"] = $token->plainTextToken;
                $response["token_type"] = 'Bearer';
                $response["msg"] = "Usuario obtenido correctamente";
                $response["user"] = $user;
                $response["api_version"] = "1.2.2";
                $response["app_version"] = "1.5.4";

//            }else{
//                $response["msg"] = "Contraseña incorrecta";
//            }
        }else{
            $response["msg"] = "Usuario no encontrado";
        }
        return response()->json($response);
    }


}
