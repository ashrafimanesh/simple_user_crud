<?php

namespace App\Exceptions;
use App\Application;
use App\Contracts\iResponse;

/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 10:42 AM
 */

class Handler{

    public function handle(\Exception $exception){

        Application::resolve(iResponse::class)->render([
            'Exception'=>[
                'message'=>$exception->getMessage()
                ,'file'=>$exception->getFile()
                ,'line'=>$exception->getLine()
            ]
        ]);
    }
}