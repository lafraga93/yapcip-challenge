<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Core\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Core\Console\Kernel::class
);

$app->configure('app');

$app->router->group([
    'namespace' => 'App\Core\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

return $app;
