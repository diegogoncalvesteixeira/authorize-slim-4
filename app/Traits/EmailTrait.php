<?php

namespace App\Traits;

use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

trait EmailTrait
{
  use RabbitMQTrait;

  public function sendEmail($name, $email, $subject, $body)
  {
    // Create the Transport
    $transport = (new Swift_SmtpTransport(config('mail.host'), config('mail.port')))
    ->setUsername(config('mail.username'))
    ->setPassword(config('mail.password'));

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message($subject))
    ->setFrom([config('mail.from.address') => config('mail.from.name')])
    ->setTo([$email => $name])
    ->setBody($body);

    // Send the message
    $mailer->send($message);
  }

  //send email with RabbitMQ
  public function sendEmailWithRabbitMQ($name, $email, $subject, $data)
  {
    $data = [
      'name' => $name,
      'email' => $email,
      'subject' => $subject,
      'data' => $data
    ];
    $this->sendToRabbitMQ($data);
  }




}