<?php

namespace Boot\Foundation\Bootstrappers;

use App\Http\HttpKernel;
use Boot\Foundation\Kernel;
use App\Console\ConsoleKernel;

class LoadEnvironmentDetector extends Bootstrapper
{
    const HTTP_ENV = HttpKernel::class;
    const CONSOLE_ENV = ConsoleKernel::class;

    public function boot()
    {
        $http = class_basename(self::HTTP_ENV) === class_basename($this->kernel);
        $console = class_basename(self::CONSOLE_ENV) === class_basename($this->kernel);

        $this->app->bind('bootedViaHttp', function () use ($http) {
          return $http;
        });
        $this->app->bind('bootedViaConsole', function () use ($console) {
          return $console;
        });

        $this->app->bind(Kernel::class, function () {
          return $this->kernel;
        });
    }
}
