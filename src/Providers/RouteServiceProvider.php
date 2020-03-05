<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 1:54 PM
 */

namespace App\Providers;


use App\Application;
use App\Contracts\iRouter;
use App\Contracts\iServiceProvider;
use App\Routing\Route;
use App\Routing\Router;

class RouteServiceProvider implements iServiceProvider
{

    public function boot(Application $app)
    {
        require_once dirname(__DIR__).'/routes.php';
    }

    public function register(Application $app)
    {
        $app->bind(iRouter::class, function(){
            return new Router();
        });

        $app->facade([
            "Route"=> Route::class,
        ]);
    }
}