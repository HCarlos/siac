<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Classes\NotificationsMobile;

class MessageCustomClass{


    public static function messageForDevice($token_devices, $title, $message, $denuncia_id, $user_id){

        // Configurar las opciones de la notificación
        return [
            "message" => [
                "token" => $token_devices,
                "notification" => [
                    "title" => $title,
                    "body" => $message,
                ],
                "data" => [
                    "denuncia_id" => (string) $denuncia_id,
                    "user_id" => (string) $user_id,
                ],
                "android" => [
                    "notification" => [
                        "click_action" => "DENUNCIA_ACTIVITY"
                    ]
                ],
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "category" => "DENUNCIAS_CATEGORY"
                        ]
                    ]
                ]
            ]
        ];
    }

    public static function messageForTopic($topic, $title, $message, $denuncia_id, $user_id){

        // Configurar las opciones de la notificación
        return [
            "message" => [
                "topic" => $topic,
                "notification" => [
                    "title" => $title,
                    "body" => $message,
                ],
                "data" => [
                    "denuncia_id" => (string) $denuncia_id,
                    "user_id" => (string) $user_id,
                ],
                "android" => [
                    "notification" => [
                        "click_action" => "DENUNCIA_ACTIVITY"
                    ]
                ],
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "category" => "DENUNCIAS_CATEGORY"
                        ]
                    ]
                ]
            ]
        ];
    }



}
