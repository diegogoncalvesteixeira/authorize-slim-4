<?php

namespace Boot\Foundation\Bootstrappers;

use Boot\Foundation\Kernel;

class LoadHttpMiddleware extends Bootstrapper
{
    public function boot()
    {
        $kernel = $this->app->resolve(Kernel::class);
//        dd($kernel);
//        $middleware = [
//            $kernel->middleware,
//            $kernel->middlewareGroups['api'],
//            $kernel->middlewareGroups['web']
//        ];
//
//        collect($middleware)
//            ->filter(function ($guard) {
//              dd($guard);
//              return class_exists($guard);
//            })
//            ->each(function ($guard) {
//              return $this->app->bind($guard, new $guard);
//            });
//
        $this->app->bind('middleware', function () use ($kernel) {
          return [
            'global' => $kernel->middleware,
            'api' => $kernel->middlewareGroups['api'],
            'web' => $kernel->middlewareGroups['web']
          ];
        });
    }
}
