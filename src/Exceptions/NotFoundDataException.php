<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 8:55 PM
 */

namespace App\Exceptions;


class NotFoundDataException extends Exception
{

    public function __construct($message = "", $code = 404, \Exception $previous = null){
        parent::__construct(...func_get_args());
    }

}