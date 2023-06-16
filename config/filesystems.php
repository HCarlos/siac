<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

        'profile' => [
            'driver' => env('PROFILE_DRIVER'),
            'root' => public_path().env('PROFILE_ROOT'),
            'url' => env('APP_URL').env('PROFILE_URL'),
            'visibility' => env('PROFILE_VISIBILITY'),
        ],

        'externo' => [
            'driver' => env('EXTERNO_DRIVER'),
            'root' => public_path().env('EXTERNO_ROOT'),
            'url' => env('APP_URL').env('EXTERNO_URL'),
            'visibility' => env('EXTERNO_VISIBILITY'),
        ],

        'denuncia' => [
            'driver' => env('DENUNCIA_DRIVER'),
            'root' => public_path().env('DENUNCIA_ROOT'),
            'url' => env('APP_URL').env('DENUNCIA_URL'),
            'visibility' => env('DENUNCIA_VISIBILITY'),
        ],

        'mobile_profile' => [
            'driver' => env('MOBILE_PROFILE_DRIVER'),
            'root' => public_path().env('MOBILE_PROFILE_ROOT'),
            'url' => env('APP_URL').env('MOBILE_PROFILE_URL'),
            'visibility' => env('MOBILE_PROFILE_VISIBILITY'),
        ],

        'mobile_servicio' => [
            'driver' => env('MOBILE_SERVICIO_DRIVER'),
            'root' => public_path().env('MOBILE_SERVICIO_ROOT'),
            'url' => env('APP_URL').env('MOBILE_SERVICIO_URL'),
            'visibility' => env('MOBILE_SERVICIO_VISIBILITY'),
        ],

        'mobile_denuncia' => [
            'driver' => env('MOBILE_DENUNCIA_DRIVER'),
            'root' => public_path().env('MOBILE_DENUNCIA_ROOT'),
            'url' => env('APP_URL').env('MOBILE_DENUNCIA_URL'),
            'visibility' => env('MOBILE_DENUNCIA_VISIBILITY'),
        ],


    ],

];
