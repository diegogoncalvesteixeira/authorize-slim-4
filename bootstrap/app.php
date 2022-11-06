<?php

use DI\Container;
use App\Http\HttpKernel;
use App\Console\ConsoleKernel;
use Boot\Foundation\AppFactoryBridge as App;
use Illuminate\Mail\MailServiceProvider;

$app = App::create(new Container);

$http_kernel = new HttpKernel($app);
$console_kernel = new ConsoleKernel($app);
//$mail_service = new MailServiceProvider($app);

$app->bind(HttpKernel::class, $http_kernel);
$app->bind(ConsoleKernel::class, $console_kernel);
//$app->bind(MailServiceProvider::class, $mail_service);

$_SERVER['app'] = &$app;

if (!function_exists('app'))
{
    function app()
    {
        return $_SERVER['app'];
    }
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app_debug = $_ENV['APP_DEBUG'];

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware($app_debug, true, true);

//transform erros into json globally
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

return $app;
