<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 1:57 PM
 */

namespace App\Support;


use App\Contracts\iResponse;

class Response implements iResponse
{

    public function render($handleRequestResponse)
    {
        //TODO handle response headers
        if(is_string($handleRequestResponse)){
            echo $handleRequestResponse;
            exit;
        }
        if($this->isAjax()){
            header('Content-Type:application/json');
        }
        if(is_array($handleRequestResponse) || is_object($handleRequestResponse)){
            echo json_encode($handleRequestResponse);
            exit;
        }
    }

    /**
     * @return bool
     */
    protected function isAjax()
    {
        return $_SERVER['HTTP_CONTENT_TYPE'] == 'application/x-www-form-urlencoded';
    }
}