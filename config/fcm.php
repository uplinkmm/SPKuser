<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'Your FCM server key'),
        // 'server_key' => null,
        'sender_id' => env('FCM_SENDER_ID', 'Your sender id'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        // 'server_send_url' => 'https://fcm.googleapis.com/v1/projects/twodmmpro/messages:send', // HTTP v1 endpoint
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'server_topic_url' => 'https://iid.googleapis.com/iid/v1/',
        'timeout' => 30.0, // in second
    ],
    'api_key' => env('FIREBASE_PROJECT'), // Use 'api_key' instead of 'server_key'

];

