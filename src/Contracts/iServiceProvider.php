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
     * @param Application $app
     * @return mixed
     */
    public function register(Application $app);

    /**
     * Publish some configs or bootstrap actions
     * @param Application $app
     * @return mixed
     */
    public function boot(Application $app);
}