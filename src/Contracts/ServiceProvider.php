<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 12:44 PM
 */

namespace App\Contracts;


use App\Application;

abstract class ServiceProvider implements iServiceProvider
{
    protected $app;

    public function __construct(Application $app){
        $this->app = $app;
    }
}