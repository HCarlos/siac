<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Classes\NotificationsMobile;

class PushNotification{


    // push message title, message and image
    private $title;
    private $message;
    private $image;

    // data payload
    private $data;

    // flag indicating whether to
    // show the push notification
    private $is_background;

    public function __construct(){

    }

    public function setTitle($title): void{
        $this->title = $title;
    }

    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function setImage($imageUrl): void
    {
        $this->image = $imageUrl;
    }

    public function setDataPayload($data): void
    {
        $this->data = $data;
    }

    public function setIsBackground($is_background): void
    {
        $this->is_background = $is_background;
    }

    public function getPushNotification(): array
    {
        $res = array();
        $res['data']['title'] = $this->title;
        $res['data']['is_background'] = $this->is_background;
        $res['data']['message'] = $this->message;
        $res['data']['image'] = $this->image;
        $res['data']['payload'] = $this->data;
        $res['data']['timestamp'] = date('Y-m-d G:i:s');

        return $res;
    }



}
