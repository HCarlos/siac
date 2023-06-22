<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Classes\NotificationsMobile;

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
            ->setData(['key' => 'value'])
        ;

        if ( ! UserMobileMessage::query()
            ->where('usermobile_id',$usermobile_id)
            ->where('user_id',$user_id)
            ->first() ) {

            $umm = UserMobileMessage::create([
                'usermobile_id' => $usermobile_id,
                'user_id' => $user_id,
                'title' => $titulo,
                'message' => $mensaje,
                'fecha' => now(),
                'is_read' => false,
            ]);

        }

        $response = $client->send($message);
        // dd( $response->getStatusCode() );
        // dd( $response->getBody()->getContents() );

        $r = (object) json_decode($response->getBody()->getContents());

        //dd( $r->results[0]->message_id );
        if (isset($umm)){

            if ( ! UserMobileMessageRequest::query()
                ->where('usermobilemessage_id',$umm->id)
                ->where('usermobile_id',$usermobile_id)
                ->where('user_id',$user_id)
                ->first() ) {


                $ummr = UserMobileMessageRequest::create([
                    'usermobilemessage_id' => $umm->id,
                    'usermobile_id' => $usermobile_id,
                    'user_id' => $user_id,
                    'multicast_id' => $r->multicast_id,
                    'success' => $r->success,
                    'failure' => $r->failure,
                    'canonical_ids' => $r->canonical_ids,
                    'message_id' => $r->results[0]->message_id,
                ]);
            }
        }

        return $response;

    }
}
