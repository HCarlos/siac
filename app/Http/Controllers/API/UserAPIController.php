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

    protected $usuarios_permitidos = [
    'SASR821123HTCLNM05','ZALA710103MTCPPR01','LODA900318HTCPZN07','COMK970121MTCRNR06','NIDL890105MTCTZD01',
    'BOFG960807HTCRNR08','GURS671021HSLZYL08','LAHC880114MTCZRN08','ZASC930417MTCVRR02','BOFE800113HTCRNN08',
    'AAGV910919MTCLMR00','CAPG591222MTCSDL01','SAZM820826MTCNCL08','ZAPA700425HTCRRL06','PAVA680726MDFLRN08',
    'RECE710501HTCYSP04','HERJ830801HTCRVN00','MABE691026HTCGXV01','CABC510519HTCSRR00','DOFP760524HTCMLL17',
    'FARW831103HTCRML07','JUGA540727HTCRRP05','LAMA701102HCSSND01','MEFL650821HVZRLS08','VAMM890403MTCLNY02',
    'GAOA790113MTCMCZ05','VELK800112MTCRPR11','Admin','SysOp','TUBI910216MNEFRS07','REAC790214HTCYBR04',
    'LAGB851220HTCMRR06','LOGE770331HTCPRS03','MAJR721218MTCYMS02','FUGA930204HCSNNL00','BERG830418HTCLMR04',
    'VIJD970811MTCLML01','VASN730629MTCZLR05','CASJ761225HTCRRS03','AEBJ860806HDFBRM09','OAPS951108HTCLRR04',
    'PEMA881014MCSRRN03','PEHE680228HDFRRN02','NIPG720308HTCCRD06',
    ];

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

        if ( !in_array($data->username, $this->usuarios_permitidos, true)) {
            $response["msg"] = "Acceso denegado!";
            return response()->json($response);
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
                $response["api_version"] = "1.2.1";
                $response["app_version"] = "1.5.3";

                if ( isset($data->deviceToken) && isset($data->device_name) ){
                    if ( ! UserMobile::query()
                        ->where('user_id',$user->id)
                        ->where('token',$data->deviceToken)
                        ->where('mobile_type',$data->device_name)
                        ->first() ) {

                        UserMobile::create([
                            'user_id' => $user->id,
                            'token' => $data->deviceToken,
                            'mobile_type' => $data->device_name,
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

        if ( !in_array($data->username, $this->usuarios_permitidos, true)) {
            $response["msg"] = "Acceso denegado!";
            return response()->json($response);
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
        $response = ["status"=>1, "msg"=>"Cuenta eliminada"];
//        $data    = (object) $request->all();
//        $user_id = $data->user_id;
//        $user = User::find($user_id);
//        if ($user){
//            if ($user->curp === "HIHC020731HTCDRRA5"){
//                $user->forceDelete($data->user_id);
//            }
//            $response["status"] = 1;
//            $response["msg"] = "Cuenta eliminada";
//        }else{
//            $response["status"] = 1;
//            $response["msg"] = "Usuario no encontrado!";
//        }
        return response()->json($response);
    }




}
