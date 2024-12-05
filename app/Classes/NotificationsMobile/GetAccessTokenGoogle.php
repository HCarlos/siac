<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Classes\NotificationsMobile;
use Exception;
use Google\Auth\CredentialsLoader;
use Google\Auth\OAuth2;
use Google\Client;
class GetAccessTokenGoogle{

    public static function getAccessTokenGoogle($type): array {
        // Ruta al archivo de la cuenta de servicio
        $urlFCM = "https://fcm.googleapis.com/v1/projects/siacentro-3ef78/messages:send";
        $creds  = env('GOOGLE_APPLICATION_CREDENTIALS_IOS');
        if ($type === "ANDROID"){
            $urlFCM = "https://fcm.googleapis.com/v1/projects/siacentro-8344d/messages:send";
            $creds  = env('GOOGLE_APPLICATION_CREDENTIALS_ANDROID');
        }

        return [
            "url" => $urlFCM,
            "creds" => $creds,
        ];


    }

    public static function getAccessToken($credencials): string {
        // Ruta al archivo de la cuenta de servicio
        $serviceAccountFile = $credencials;

        // Alcances requeridos (SCOPES)
        $scopes = ['https://www.googleapis.com/auth/cloud-platform']; // Cambia según tus necesidades

        // Cargar las credenciales de la cuenta de servicio
        $credentials = json_decode(file_get_contents($serviceAccountFile), true);

        // Crear un cliente de Google y configurar las credenciales
        $client = new Client();
        $client->setAuthConfig($credentials);
        $client->setScopes($scopes);

        // Obtener el token de acceso
        $accessToken = $client->fetchAccessTokenWithAssertion();

        // Devolver el valor del token
        return $accessToken['access_token'];
    }

    public static function sendMessageFCM($url, $accessToken, $message){
        // Inicializar cURL
        $ch = curl_init($url);

        // Configurar las opciones de cURL
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken", // Token de acceso del servicio
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message, JSON_PRETTY_PRINT)); // Cuerpo de la solicitud en JSON

        // Ejecutar la solicitud
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Verificar errores
        if ($response === false) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }

        // Cerrar la sesión cURL
        curl_close($ch);

        // Devolver la respuesta
        return [
            "httpCode" => $httpCode,
            "response" => $response
        ];

    }

    public static function sendFCMForDevice($device_topic, $type, $titulo, $mensaje, $denuncia_id, $user_id) {
        // Endpoint HTTP v1 de Firebase
        $datos = static::getAccessTokenGoogle($type);
        $accessToken = static::getAccessToken($datos['creds']);
        return static::sendMessageFCM($datos['url'], $accessToken, MessageCustomClass::messageForDevice($device_topic, $titulo, $mensaje, $denuncia_id, $user_id));
    }



}
