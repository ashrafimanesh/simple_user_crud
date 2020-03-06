<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/4/20
 * Time: 8:20 AM
 */

namespace App\Providers;


use App\Application;
use App\Contracts\iResponse;
use App\Contracts\ServiceProvider;
use App\Requests\Request;
use App\Support\Response;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app->setConfig('database',require $this->app->appPath('configs/database.php'));
    }

    public function register()
    {
        $this->app->singleton(Request::class,function(){
            $req = new Request();
            return $req;
        });

        $this->app->bind(iResponse::class,function(){
            return new Response();
        });
    }
}