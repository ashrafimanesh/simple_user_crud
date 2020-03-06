<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 2:53 PM
 */

namespace App\Exceptions;


use App\Support\Validator\Validator;

class RequestValidationException extends Exception
{
    /** @var  Validator  */
    protected $validator;

    public function __construct($message = "", $code = 400, \Exception $previous = null){
        parent::__construct(...func_get_args());
    }

    /**
     * @param Validator $validator
     * @return RequestValidationException
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
        return $this;
    }

    /**
     * @return Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }
}