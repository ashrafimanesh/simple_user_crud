<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 1:54 PM
 */

namespace App\Providers;


use App\Contracts\iRouter;
use App\Contracts\ServiceProvider;
use App\Routing\Route;
use App\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{

    public function boot()
    {
        require_once dirname(__DIR__).'/routes.php';
    }

    public function register()
    {
        $this->app->bind(iRouter::class, function(){
            return new Router();
        });

        $this->app->facade([
            "Route"=> Route::class,
        ]);
    }
}