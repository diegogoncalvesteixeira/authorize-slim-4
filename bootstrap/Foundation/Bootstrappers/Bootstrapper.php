<?php

namespace Boot\Foundation\Bootstrappers;

class Bootstrapper
{
    public $app;
    public $kernel;

    final public function __construct(&$app, &$kernel)
    {
        $this->app = $app;
        $this->kernel = $kernel;
    }

    final public static function setup(&$app, &$kernel, array $bootstrappers)
    {
        collect($bootstrappers)
            ->map(function ($bootstrapper) use ($app, $kernel) {
              return new $bootstrapper($app, $kernel);
            })
            ->each(function (Bootstrapper $bootstrapper) {
              return $bootstrapper->beforeBoot();
            })
            ->each(function (Bootstrapper $bootstrapper) {
              return $bootstrapper->boot();
            })
            ->each(function (Bootstrapper $bootstrapper) {
              return $bootstrapper->afterBoot();
            });
    }

    public function beforeBoot()
    {
        //
    }

    public function boot()
    {
        //
    }

    public function afterBoot()
    {
        //
    }
}
