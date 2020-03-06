<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 10:16 PM
 */

namespace App\Exceptions;


class Exception extends \Exception
{
    public function __construct($message = "", $code = 500, \Exception $previous = null){
        parent::__construct(...func_get_args());
        $this->message = $message;
        $this->code = $code;
    }

}