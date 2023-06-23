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
use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Notification;

class SendNotificationFCM{


    public function __construct(){ }

    public function sendNotification($usermobile_id, $user_id, $device_name, $devicetoken, $titulo, $mensaje ){
        $server_key = config('atemun.fcm.server_ios_key');
        if ( $device_name === "ANDROID"){
            $server_key = config('atemun.fcm.server_android_key');
        }

        $client = new Client();
        $client->setApiKey($server_key);
        $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());
        $message = new Message();
        $message->setPriority('high');
        $message->addRecipient(new Device($devicetoken));
        $message
            ->setNotification(new Notification($titulo, $mensaje))
            ->setData(['valid' => true])
        ;
        $response = $client->send($message);
        $r = (object)json_decode($response->getBody()->getContents());
        if ($r->failure === 0) {
            if ($response->getStatusCode() === 200) {

//                if (!UserMobileMessage::query()
//                    ->where('usermobile_id', $usermobile_id)
//                    ->where('user_id', $user_id)
//                    ->first()) {

                    $umm = UserMobileMessage::create([
                        'usermobile_id' => $usermobile_id,
                        'user_id' => $user_id,
                        'title' => $titulo,
                        'message' => $mensaje,
                        'fecha' => now(),
                        'is_read' => false,
                    ]);

//                }

                // dd( $response->getStatusCode() );
                // dd( $response->getBody()->getContents() );


                //dd( $r->results );
                if (isset($umm)) {

//                    if (!UserMobileMessageRequest::query()
//                        ->where('usermobilemessage_id', $umm->id)
//                        ->where('usermobile_id', $usermobile_id)
//                        ->where('user_id', $user_id)
//                        ->first()) {

                        $resp = $r->results[0]->message_id ?? '';
                        $ummr = UserMobileMessageRequest::create([
                            'usermobilemessage_id' => $umm->id,
                            'usermobile_id' => $usermobile_id,
                            'user_id' => $user_id,
                            'multicast_id' => $r->multicast_id,
                            'success' => $r->success,
                            'failure' => $r->failure,
                            'canonical_ids' => $r->canonical_ids,
                            'message_id' => $resp,
                        ]);
//                    }
                }
                $um = UserMobile::find($usermobile_id);
                $um->enabled = true;
                $um->save();
            } else {
                $um = UserMobile::find($usermobile_id);
                $um->enabled = false;
                $um->save();
            }
        } else{
            $um = UserMobile::find($usermobile_id);
            $um->enabled = false;
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
            $user_id = $dm->ciudadano_id;
            $respuesta = $Item->respuesta;
            $IsValidQuery = true;
        }
        if ($IsValidQuery){
            $usermobile = UserMobile::query()->where('user_id', $user_id)->get();
            foreach ($usermobile as $um){
                $response = $fcm->sendNotification($um->id,$um->user_id,$um->mobile_type,$um->token,$dm->denuncia,$respuesta);
            }
        }
        return $Item;
    }



}
