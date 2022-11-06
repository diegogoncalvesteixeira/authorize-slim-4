<?php

return [
    'method' => env('MAIL_SEND_METHOD', 'email'),
    'driver' => env('MAIL_MAILER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.mailtrap.io'),
    'port' => env('MAIL_PORT', 465),
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'from@example.com'),
        'name' => env('MAIL_FROM_NAME', 'From Example')
    ],
    'to' => [
        'address' => env('MAIL_TO_ADDRESS', 'to@example.com'),
        'name' => env('MAIL_TO_NAME', 'To Example')
    ],

    'encryption' => env('MAIL_ENCRYPTION', 'tls'),

    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),

    'markdown' => [
        'theme' => 'default',
        'paths' => resources_path('views/mail')
    ],

    'log_channel' => env('MAIL_LOG_CHANNEL')
];
