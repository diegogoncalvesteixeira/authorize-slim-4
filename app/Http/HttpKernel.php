<?php

namespace App\Http;

use Boot\Foundation\HttpKernel as Kernel;

class HttpKernel extends Kernel
{
    /**
     * Injectable Request Input Form Request Validators
     * @var array
     */
    public $requests = [
        Requests\StoreUserRequest::class,
        Requests\TokenRequest::class,
    ];

    /**
     * Global Middleware
     *
     * @var array
     */
    public $middleware = [];

    /**
     * Route Group Middleware
     */
    public $middlewareGroups = [
        'api' => [
            Middleware\ApiMiddleware::class,
        ],
        'web' => [
            Middleware\RouteContextMiddleware::class,
        ]
    ];
}
