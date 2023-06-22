<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Classes\NotificationsMobile;

class FirebaseCloudMessaging{

    // this methods send messages to a single device
    /**
     * @throws \JsonException
     */
    public function send($to, $message){
        $fields = array(
            'to' => $to,
            'data' => $message,
        );
        return $this->sendPushNotification($fields);
    }

    // Send message to topic subscribers

    /**
     * @throws \JsonException
     */
    public function sendToTopic($to, $message){
        $fields = array(
            'to' => '/topics/'. $to,
            'data' => $message,
        );

        return $this->sendPushNotification($fields);
    }

    // Send push message to multiple devices

    /**
     * @throws \JsonException
     */
    public function sendToMultipleDevices($registrationIds, $message){
        $fields = array(
            'to' => $registrationIds,
            'data' => $message,
        );

        return $this->sendPushNotification($fields);
    }

    // CURL request to Firebase Platform

    /**
     * @throws \JsonException
     */
    private function sendPushNotification($fields)
    {

        require_once __DIR__ . '/config.php';

        // POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization: key=' . 'AAAAOxp8RQA:APA91bEQIojJa-3wWzgJRuLvm11c2qSJJG-oziCAYFWRyD7vkf7flyKBNZC0qEprPpIwpA-OuScGrjGQqBhp6zEDCkj0z6MhVLVEf9R9g8zSsKjowT6qghhm1fbPB9mcAxCmFiJQkcld',
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the URL, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        // Disable SSL Certificate Support temporary
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 64);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields, JSON_THROW_ON_ERROR));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        } else {
            json_decode($result, false, 512, JSON_THROW_ON_ERROR);
        }

        // Close connection
        curl_close($ch);

        return $result;

    }

}
