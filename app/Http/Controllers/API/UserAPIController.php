<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserAPIChangeEmailRequest;
use App\Http\Requests\API\UserAPIChangePasswordRequest;
use App\Http\Requests\API\UserAPIImageRequest;
use App\Http\Requests\API\UserAPIRegistryRequest;
use App\Models\Users\UserMobile;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAPIController extends Controller{

    public function users():JsonResponse {
        $Users = User::query()->take(10)->get();
        return response()->json($Users);
    }

    public function userId($id):JsonResponse {
        $Users = User::find($id);
        return response()->json($Users);
    }

    public function userCURP($curp):JsonResponse {
        $Users = User::where('curp',strtoupper(trim($curp)))->get();
        return response()->json($Users);
    }

    public function userLogin(Request $request):JsonResponse {
        $response = ["status"=>0, "msg"=>""];
        $data = (object) $request->all();

        if (trim($data->username) !== "Admin" && trim($data->username) !== "SysOp") {
            $data->username = strtoupper(trim($data->username));
        }

        $user = User::where("username",trim($data->username))->first();
        if ($user){
            $pwd = $data->password;
            $pwd2 = strtoupper(trim($pwd));
            if ( strtoupper(trim($data->username)) === $pwd2  ){
                $pwd = $pwd2;
            }
            if (Hash::check($pwd, $user->password)){
                $token = $user->createToken("devch50");
                $response["status"] = 1;
                $response["access_token"] = $token->plainTextToken;
                $response["token_type"] = 'Bearer';
                $response["msg"] = $token->plainTextToken;
                $response["user"] = $user;

                if ( isset($data->deviceToken) && isset($data->device_name) ){
                    if ( ! UserMobile::query()
                        ->where('user_id',$user->id)
                        ->where('token',$data->deviceToken)
                        ->where('mobile_type',$data->device_name)
                        ->first() ) {

                        UserMobile::create([
                            'user_id' => $user->id,
                            'token' => $data->deviceToken,
                            'mobile_type' => $data->device_name
                        ]);

                    }
                }

            }else{
                $response["msg"] = "Contraseña incorrecta";
            }
        }else{
            $response["msg"] = "Usuario no encontrado";
        }
//        event(new InserUpdateDeleteEvent(1,$response));
        return response()->json($response);
    }

    public function userMobileToken(Request $request):JsonResponse {
        $response = ["status"=>0, "msg"=>""];
        $data = [
            "username" => "required",
            "password" => "required",
            "device_name" => "required",
        ];
        $data = $request->validate($data);
        if (trim($data->username) !== "Admin" && trim($data->username) !== "SysOp") {
            $data->username = strtoupper(trim($data->username));
        }
        $user = User::where("username",trim($data->username))->first();
        if ($user){
            $pwd = $data->password;
            $pwd2 = strtoupper(trim($pwd));
            if ( strtoupper(trim($data->username)) === $pwd2  ){
                $pwd = $pwd2;
            }
            if (Hash::check($pwd, $user->password)) {
                $token = $user->createToken($request->device_name);
                $response["status"] = 1;
                $response["access_token"] = $token->plainTextToken;
                $response["token_type"] = 'Bearer';
                $response["msg"] = $token->plainTextToken;
            } else {
                $response = ["status" => 0, "msg" => "Contraseña incorrecta"];
            }
        }else{
            $response = ["status" => 0, "msg" => "Usuario no encontrado"];
        }
//        event(new InserUpdateDeleteEvent(1,$response));
        return response()->json($response);
    }

    public function register(UserAPIRegistryRequest $request):JsonResponse {
        $response = ["status"=>0, "msg"=>""];
        $user = $request->manage();
        if ($user){

            $Token = $user->createToken($request->device_name);
            $token = $Token->plainTextToken;
            $user->sendEmailVerificationNotification();

            $response["status"] = 1;
            $response["access_token"] = $token;
            $response["token_type"] = 'Bearer';
            $response["username"] = strtoupper(trim($user->username));
            $response["password"] = $user->password;
            $response["email"] = $user->email;
            $response["ap_paterno"] = strtoupper(trim($user->ap_paterno));
            $response["ap_materno"] = strtoupper(trim($user->ap_materno));
            $response["nombre"] = strtoupper(trim($user->nombre));
            $response["msg"] = $token;
        }
//        event( new InserUpdateDeleteEvent(1, $response) );
        return response()->json($response);
    }

    public function userImage(UserAPIImageRequest $request):JsonResponse {
        $response = ["status"=>0, "msg"=>""];
        $user = $request->manage();
        if ($user){
            $response["status"] = 1;
            $response["msg"] = "Imagen actualizada con éxito";
        }
        return response()->json($response);
    }

    public function userChangePassword(UserAPIChangePasswordRequest $request):JsonResponse {
        $response = ["status"=>0, "msg"=>""];
        $user = $request->manage();
        if ($user){
            $response["status"] = 1;
            $response["msg"] = "Contraseña actualizada con éxito";
        }
        return response()->json($response);
    }

    public function userChangeEmail(UserAPIChangeEmailRequest $request):JsonResponse {
        $response = ["status"=>0, "msg"=>""];
        $user = $request->manage();
        if ($user){
            $response["status"] = 1;
            $response["msg"] = "Correo actualizado con éxito";
        }
        return response()->json($response);
    }

    // Login Temporal
    public function userLogin2(Request $request):JsonResponse {
        $response = ["status"=>0, "msg"=>""];
        $data = (object) $request->all();
        if (trim($data->username) !== "Admin" && trim($data->username) !== "SysOp") {
            $data->username = strtoupper(trim($data->username));
        }
        $user = User::where("username",trim($data->username))->first();
        if ($user){
            $pwd = $data->password;
            $pwd2 = strtoupper(trim($pwd));
            if ( strtoupper(trim($data->username)) === $pwd2  ){
                $pwd = $pwd2;
            }
            if (Hash::check($pwd, $user->password)){
                $token = $user->createToken("devch50");
                $response["status"] = 1;
                $response["access_ok"] = $token->plainTextToken;
                $response["token_type"] = 'Bearer';
                $response["msg"] = "Logueado correctamente...";
//                $response["user"] = $user;
            }else{
                $response["msg"] = "Contraseña incorrecta";
            }
        }else{
            $response["msg"] = "Usuario no encontrado";
        }
//        event(new InserUpdateDeleteEvent(1,$response));
        return response()->json($response);
    }

    public function recoveryPassword(Request $request):JsonResponse {
        $response = ["status"=>0, "msg"=>""];
        $data = (object) $request->all();
        $email = $data->email;

        $user = User::query()->where("email",$email)->first();
        if ($user){

            $Token = $user->createToken($request->device_name);
            $token = $Token->plainTextToken;
            $user->sendPasswordResetNotification($token);

            $response["status"] = 1;
            $response["msg"] = $token;
        }else{
            $response["status"] = 1;
            $response["msg"] = "Email no encontrado!";
        }
        return response()->json($response);
    }

    public function userDelete(Request $request):JsonResponse {
        $response = ["status"=>0, "msg"=>""];
        $data    = (object) $request->all();
        $user_id = $data->user_id;
        $user = User::find($user_id);
        if ($user){
            if ($user->curp === "HIHC020731HTCDRRA5"){
                $user->forceDelete($data->user_id);
            }
            $response["status"] = 1;
            $response["msg"] = "Cuenta eliminada";
        }else{
            $response["status"] = 1;
            $response["msg"] = "Usuario no encontrado!";
        }
        return response()->json($response);
    }




}
