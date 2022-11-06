<?php

namespace Boot\Foundation\Providers;

use App\Support\Route;
use App\Support\RouteGroup;

class RouteServiceProvider extends SlimServiceProvider
{
    public function beforeRegistering()
    {
        Route::setup($this->app);

        $this->bind(RouteGroup::class, function () {
          return new RouteGroup($this->app);
        });
    }
}
