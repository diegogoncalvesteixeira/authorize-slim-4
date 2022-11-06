<?php

namespace App\Providers;

use App\Listeners\FlashSuccessMessage;
use Boot\Foundation\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
      //example
      //event()->listen('example.error', function ($message) {
      //  return session()->flash()->add('error', $message);
      //});
    }
}
