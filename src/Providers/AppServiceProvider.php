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
use App\Contracts\iServiceProvider;
use App\Requests\Request;
use App\Support\Response;

class AppServiceProvider implements iServiceProvider
{

    public function boot(Application $app)
    {
    }

    public function register(Application $app)
    {
        $app->singleton(Request::class,function(){
            $req = new Request();
            return $req;
        });

        $app->bind(iResponse::class,function(){
            return new Response();
        });

        $app->facade([
            'ExceptionHandler'=>\App\Exceptions\Handler::class,
        ]);
    }
}