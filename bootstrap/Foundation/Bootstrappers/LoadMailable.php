<?php


namespace Boot\Foundation\Bootstrappers;

use Jenssegers\Blade\Blade;
use Swift_Mailer as Mailer;
use Swift_Message as Email;
use Boot\Foundation\Mail\Mailable;
use Swift_SmtpTransport as EmailTransport;

class LoadMailable extends Bootstrapper
{
    public function boot()
    {
        $mail = config('mail');

        $this->app->bind(EmailTransport::class, function () use ($mail) {
          return (new EmailTransport($mail['host'], $mail['port']))->setUsername($mail['username'])->setPassword($mail['password']);
        }
        );

        $this->app->bind(Mailer::class, function (EmailTransport $transport) {
          return new Mailer($transport);
        });

        $this->app->bind(Email::class, function () use ($mail) {
          return (new Email('Default Subject'))->setTo([$mail['to']['address'] => $mail['to']['name']])->setFrom([$mail['from']['address'] => $mail['from']['name']])->setBody('Hello World!');
        }
        );

        $this->app->bind(Mailable::class, function (Mailer $mailer, Email $email, Blade $blade) {
          return new Mailable($mailer, $email, $blade);
        });
    }
}
