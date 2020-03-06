<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 12:53 PM
 */

namespace App\Contracts;


use App\Application;

interface iServiceProvider
{
    /**
     * This method call before boot and you can register all providers or alias in this method.
     * @return mixed
     */
    public function register();

    /**
     * Publish some configs or bootstrap actions
     * @return mixed
     */
    public function boot();
}