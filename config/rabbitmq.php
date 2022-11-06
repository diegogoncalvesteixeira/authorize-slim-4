<?php

return [
  'host' => env('RMQ_HOST', 'localhost'),
  'port' => env('RMQ_PORT', '15672'),
  'username' => env('RMQ_USERNAME', 'guest'),
  'password' => env('RMQ_PASSWORD', 'guest'),
  'mail_queue' => env('RMQ_MAIL_QUEUE', 'email'),
];
