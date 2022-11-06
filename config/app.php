<?php

return [
    /**
     * Application name
     */
    'name' => env('APP_NAME', 'Jobsity Challenge'),

    /**
     * Application Environment
     */
    'env' => env('APP_ENV', 'dev'),

    /**
     * Application Environment
     */
    'key' => env('APP_KEY', 'example_key'),

    /**
     * Determine if you want to display extended debug information
     * within the browser
     */
    'app_debug' => env('APP_DEBUG', false),

    /**
     * Register App Url
     */
    'url' => env('APP_URL', 'http://jobsity'),

    /**
     * Register Timezone
     */
    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /**
     * The application locale Determines the default locale that will be used
     * by the translation service provider. You are free to set this value
     * to any of the locales which will be supported by the application
     */
    'locale' => 'en',

    /**
     * This locale will be used by the Faker Php library when generating
     * fake data
     */
    'faker_locale' => 'en_US',

    'providers' => [
        /* Booted Foundation Service Providers...  */
        \Boot\Foundation\Providers\FileSystemServiceProvider::class,
        \Boot\Foundation\Providers\TranslatorServiceProvider::class,
        \Boot\Foundation\Providers\ValidatorServiceProvider::class,

        /* App Service Providers... */
        \App\Providers\AuthServiceProvider::class,
        \App\Providers\EventServiceProvider::class,
        \App\Providers\DatabaseServiceProvider::class,
    ],
    'aliases' => [
        'Auth' => \App\Support\Auth::class,
        'DB' => \Illuminate\Database\Capsule\Manager::class,
        'Mail' => \Illuminate\Support\Facades\Mail::class,
    ]
];
