<?php


namespace Boot\Foundation;


class HttpKernel extends Kernel
{
    /**
     * Injectable Request Input Form Request Validators
     * @var array
     */
    public $requests = [];

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
        'api' => [],
        'web' => []
    ];

    public $bootstrappers = [
        Bootstrappers\LoadSession::class,
        Bootstrappers\LoadEnvironmentDetector::class,
        Bootstrappers\LoadEnvironmentVariables::class,
        Bootstrappers\LoadConfiguration::class,
        Bootstrappers\LoadDebuggingPage::class,
        Bootstrappers\LoadAliases::class,
        Bootstrappers\LoadCsrf::class,
        Bootstrappers\LoadHttpMiddleware::class,
        Bootstrappers\LoadBladeTemplates::class,
        Bootstrappers\LoadMailable::class,
        Bootstrappers\LoadServiceProviders::class,
    ];
}
