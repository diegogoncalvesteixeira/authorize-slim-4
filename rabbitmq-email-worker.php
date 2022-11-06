<?php

//autoload
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mq_host = $_ENV['RMQ_HOST'];
$mq_port = $_ENV['RMQ_PORT'];
$mq_username = $_ENV['RMQ_USERNAME'];
$mq_password = $_ENV['RMQ_PASSWORD'];
$mq_queue = $_ENV['RMQ_MAIL_QUEUE'];


function sendEmail($payload)
{
  $email_host = $_ENV['MAIL_HOST'];
  $email_port = $_ENV['MAIL_PORT'];
  $email_username = $_ENV['MAIL_USERNAME'];
  $email_password = $_ENV['MAIL_PASSWORD'];
  $email_from_address = $_ENV['MAIL_FROM_ADDRESS'];
  $email_from_name = $_ENV['MAIL_FROM_NAME'];

  $subject = $payload->{'subject'};
  $name = $payload->{'name'};
  $email = $payload->{'email'};
  $body = $payload->{'data'};
  $mensagem = $body->stock_json;

  // Create the Transport
  $transport = (new Swift_SmtpTransport($email_host, $email_port))
  ->setUsername($email_username)
  ->setPassword($email_password);

  // Create the Mailer using your created Transport
  $mailer = new Swift_Mailer($transport);

  // Create a message
  $message = (new Swift_Message($subject))
  ->setFrom([$email_from_address => $email_from_name])
  ->setTo([$email => $name])
  ->setBody($mensagem);

  // Send the message
  $mailer->send($message);

  return;
}


$connection = new AMQPStreamConnection($mq_host, $mq_port, $mq_username, $mq_password);
$channel = $connection->channel();

$channel->queue_declare($mq_queue, false, true, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function ($msg) {
    echo " [x] Received ", $msg->body, "\n";
    $payload = json_decode($msg->body);
    sleep(2);
    sendEmail($payload);
    echo " [x] Done", "\n";
};

$channel->basic_consume($mq_queue, '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
  $channel->wait();
}

$channel->close();
$connection->close();