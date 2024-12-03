<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Classes\NotificationsMobile;

use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use sngrl\PhpFirebaseCloudMessaging\Notification;

class MyClient extends Client{

    const DEFAULT_API_URL = 'https://fcm.googleapis.com/v1/projects/siac-villahermos-1715790465415/messages:send';
    const DEFAULT_TOPIC_ADD_SUBSCRIPTION_API_URL = 'https://iid.googleapis.com/iid/v1:batchAdd';
    const DEFAULT_TOPIC_REMOVE_SUBSCRIPTION_API_URL = 'https://iid.googleapis.com/iid/v1:batchRemove';

}
