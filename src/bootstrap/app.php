<?php

$basePath = dirname(dirname(__DIR__));
require $basePath .'/vendor/autoload.php';

$app = new \App\Application($basePath);

$app->providers([
    App\Providers\AppServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\StorageServiceProvider::class,
]);

try {
    Dotenv\Dotenv::createImmutable($basePath)->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}
return $app;