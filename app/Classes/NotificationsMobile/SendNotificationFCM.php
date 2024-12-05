<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Classes\NotificationsMobile;

use App\Models\Denuncias\Denuncia;
use App\Models\Mobiles\Denunciamobile;
use App\Models\Users\UserMobile;
use App\Models\Users\UserMobileMessage;
use App\Models\Users\UserMobileMessageRequest;

//use sngrl\PhpFirebaseCloudMessaging\Message;
//use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
//use sngrl\PhpFirebaseCloudMessaging\Notification;

class SendNotificationFCM{


    public function __construct(){ }

    public function sendNotification($usermobile_id, $user_id, $device_name, $devicetoken, $titulo, $mensaje, $denuncia_id ){

        if ( $device_name === "ANDROID"){
            // Enviar a Android
            $resultAndroid = GetAccessTokenGoogle::sendFCMForDevice($devicetoken, $device_name, $titulo, $mensaje, $denuncia_id, $user_id);
            $response = $resultAndroid['response'] . PHP_EOL;
            // echo "Android Response: " . $resultAndroid['response'] . PHP_EOL;
        }else{
            // Enviar a Apple
            $resultApple = GetAccessTokenGoogle::sendFCMForDevice($devicetoken, $device_name, $titulo, $mensaje, $denuncia_id, $user_id);
            $response = $resultApple['response'] . PHP_EOL;
            //echo "Apple Response: " . $resultApple['response'] . PHP_EOL;
        }

        $response = (object) json_decode($response, true);

//        dd($response);

        if ( isset($response->error) ){

            $um = UserMobile::find($usermobile_id);
            $um->enabled = false;
            $um->save();

            return false;
        }

//        dd($response);

        if ( isset($response->name) ) {

//            dd($response->name);

            $umm = UserMobileMessage::create([
                'usermobile_id' => $usermobile_id,
                'user_id' => $user_id,
                'title' => $titulo,
                'message' => $mensaje,
                'fecha' => now(),
                'is_read' => false,
            ]);

            if (isset($umm)) {

                    $resp = $response->name ?? '';
                    $name = explode('/',$response->name);
                    $ummr = UserMobileMessageRequest::create([
                        'usermobilemessage_id' => $umm->id,
                        'usermobile_id' => $usermobile_id,
                        'user_id' => $user_id,
                        'multicast_id' => $name[3],
                        'success' => 1,
                        'failure' => 0,
                        'canonical_ids' => 0,
                        'message_id' => $name[3],
                    ]);
            }
            $um = UserMobile::find($usermobile_id);
            $um->enabled = true;
            $um->save();

        }

        return $response;

    }


    public function sendNotificationMobile($Item,$Type){
        $fcm = new SendNotificationFCM();
        $user_id = 0;
        $respuesta = "";
        $IsValidQuery = false;
        if ($Type === 0){
            $dm = Denunciamobile::find($Item->denunciamobile_id);
            $user_id = $Item->user_id;
            $respuesta = $Item->respuesta;
            $IsValidQuery = true;
        }else if ($Type === 1){
            $dm = Denuncia::find($Item->denuncia__id);
            $user_id = $Item->user__id;
            $respuesta = $Item->respuesta;
            $IsValidQuery = true;
        }else if ($Type === 2){
            $dm = Denuncia::find($Item->denuncia__id);
            $user_id = $Item->user__id;
            $respuesta = $Item->respuesta;
            $IsValidQuery = true;
        }else if ($Type === 3){
            $dm = Denuncia::find($Item->denuncia_id);
            $user_id = $dm->ciudadano_id ?? 1;
            $respuesta = $Item->respuesta ?? '';
            $IsValidQuery = true;
        }
        if ($IsValidQuery){
            $usermobile = UserMobile::query()->where('user_id', $user_id)->get();
            foreach ($usermobile as $um){
                if ($um) {
                    $fcm->sendNotification($um->id, $um->user_id, $um->mobile_type, $um->token, $dm->denuncia, $respuesta, $dm->denuncia);
                }
            }
        }
        return $Item;
    }



}
