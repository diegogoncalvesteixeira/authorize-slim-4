<?php

namespace Boot\Foundation\Providers;

use Psr\Container\ContainerInterface;

abstract class SlimServiceProvider
{
    public $app;
    public $container;

    final public function __construct(&$app)
    {
        $this->app = $app;
        $this->container = $this->app->getContainer();

        if (method_exists($this, 'beforeRegistering'))
        {
            $this->beforeRegistering();
        }
    }

    public function bind($key, callable $resolvable)
    {
        $this->container->set($key, $resolvable);
    }

    public function resolve($key)
    {
        return $this->container->get($key);
    }

    final public static function setup(&$app, array $providers)
    {
        $run_when_exists = function ($provider, $method) {
          return method_exists($provider, $method) ? $provider->$method() : NULL;
        };

        collect($providers)
            ->map(function ($provider) use ($app) {
              return new $provider($app);
            })
            ->each(function (SlimServiceProvider $provider) use ($run_when_exists) {
              return $run_when_exists($provider, 'register');
            })
            ->each(function (SlimServiceProvider $provider) use ($run_when_exists) {
              return $run_when_exists($provider, 'boot');
            });
    }
}
