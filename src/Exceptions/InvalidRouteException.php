<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 10:33 AM
 */

namespace App\Exceptions;


class InvalidRouteException extends Exception
{

    public function __construct($message = "", $code = 500, \Exception $previous = null){
        parent::__construct(...func_get_args());
    }

}