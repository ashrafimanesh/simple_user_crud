<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 10:03 PM
 */

namespace App\DataModels;


class BaseResponse
{
    public $code=200;
    public $data= [];
    public $message='';

    public function __construct($data = [], $code=200, $message=''){

        $this->data = $data;
        $this->code = $code;
        $this->message = $message;
    }
}