<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Classes\NotificationsMobile;

use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Notification;

use GuzzleHttp;

class MyClient extends Client{

//    const DEFAULT_API_URL = 'https://fcm.googleapis.com/fcm/send';
    const DEFAULT_API_URL = 'https://fcm.googleapis.com/v1/projects/siacentro-8344d/messages:send';
    const DEFAULT_TOPIC_ADD_SUBSCRIPTION_API_URL = 'https://iid.googleapis.com/iid/v1:batchAdd';
    const DEFAULT_TOPIC_REMOVE_SUBSCRIPTION_API_URL = 'https://iid.googleapis.com/iid/v1:batchRemove';



    private $apiKey;
    private $proxyApiUrl;
    private $guzzleClient;

    public function injectGuzzleHttpClient(GuzzleHttp\ClientInterface $client)
    {
        $this->guzzleClient = $client;
    }

    public function setApiKey($apiKey): MyClient
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function setProxyApiUrl($url): MyClient
    {
        $this->proxyApiUrl = $url;
        return $this;
    }

    public function send(Message $message)
    {
        return $this->guzzleClient->post(
            $this->getApiUrl(),
            [
                'headers' => [
                    'Authorization' => sprintf('key=%s', $this->apiKey),
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($message, JSON_THROW_ON_ERROR)
            ]
        );
    }

    public function sendMe(Message $message, $accessToken){
        return $this->guzzleClient->post(
            $this->getApiUrl(),
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($message, JSON_THROW_ON_ERROR)
            ]
        );
    }


    /**
     * @throws \JsonException
     */
    public function addTopicSubscription($topic_id, $recipients_tokens)
    {
        return $this->processTopicSubscription($topic_id, $recipients_tokens, self::DEFAULT_TOPIC_ADD_SUBSCRIPTION_API_URL);
    }


    /**
     * @throws \JsonException
     */
    public function removeTopicSubscription($topic_id, $recipients_tokens)
    {
        return $this->processTopicSubscription($topic_id, $recipients_tokens, self::DEFAULT_TOPIC_REMOVE_SUBSCRIPTION_API_URL);
    }


    /**
     * @throws \JsonException
     */
    protected function processTopicSubscription($topic_id, $recipients_tokens, $url){

        if (!is_array($recipients_tokens))
            $recipients_tokens = [$recipients_tokens];

        return $this->guzzleClient->post(
            $url,
            [
                'headers' => [
                    'Authorization' => sprintf('key=%s', $this->apiKey),
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode([
                    'to' => '/topics/' . $topic_id,
                    'registration_tokens' => $recipients_tokens,
                ], JSON_THROW_ON_ERROR)
            ]
        );
    }


    private function getApiUrl(): string
    {
        return $this->proxyApiUrl ?? self::DEFAULT_API_URL;
    }



}
