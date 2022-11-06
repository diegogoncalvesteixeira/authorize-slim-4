<?php

namespace  App\Traits ;

 use PhpAmqpLib\Connection\AMQPStreamConnection;
 use PhpAmqpLib\Message\AMQPMessage;

trait RabbitMQTrait
{
  //send data to RabbitMQ
  public function sendToRabbitMQ($data)
  {
    $connection = new AMQPStreamConnection(config('rabbitmq.host'), config('rabbitmq.port'), config('rabbitmq.username'), config('rabbitmq.password'));
    $channel = $connection->channel();

    $channel->queue_declare(config('rabbitmq.mail_queue'), false, true, false, false);

    $msg = new AMQPMessage(json_encode($data));
    $channel->basic_publish($msg,'', config('rabbitmq.mail_queue'));

    $channel->close();
    $connection->close();
  }
}