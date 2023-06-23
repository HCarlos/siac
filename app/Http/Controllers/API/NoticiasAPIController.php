<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Mobiles\Denunciamobile;
use App\Models\Mobiles\Serviciomobile;
use App\Models\Users\UserMobile;
use App\Models\Users\UserMobileMessage;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoticiasAPIController extends Controller{

    public function getNoticiasFromUser(Request $request): JsonResponse{
        $response = ["status"=>0, "msg"=>""];
        $data = (object) $request->all();
        $user_id = $data->user_id;
        $device_name = $data->device_name;
        $um = UserMobile::select(['id'])
            ->where('user_id', $user_id)
            ->where('mobile_type', $device_name)
            ->get()
            ->pluck('id');

// $um = explode($um);

//dd($um);

        $umm = UserMobileMessage::query(['id','user_id','usermobile_id','campania','title','message','fecha','tags','is_read'])
            ->whereIn("usermobile_id",$um)
            ->OrderByDesc("id")
            ->get();
        if ($umm){
            $response["status"] = 1;
            $response["msg"] = "OK";
            $message = array();
            foreach ($umm as $_umm){
                $fecha = (new Carbon($_umm->fecha))->format('d-m-Y H:i:s');
                $m = [
                    'id'               => $_umm->id,
                    'usermobile_id'    => $_umm->usermobile_id,
                    'campania'         => $_umm->denuncia,
                    'fecha'            => $fecha,
                    'title'            => $_umm->title,
                    'message'          => $_umm->message,
                    'tags'             => $_umm->tags,
                    'is_read'          => $_umm->is_read,
                    'user_id'          => $user_id,
                    'device_name'      => $device_name,
                ];
                $message[] = $m;
            }
            $response["message"] = $message;
        }
        return response()->json($response);

    }




}
