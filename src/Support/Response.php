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
        if($this->isAjax() || $this->isJson()){
            header('Content-Type:application/json');
        }

        if(is_array($handleRequestResponse)){
            echo json_encode($handleRequestResponse);
            exit;
        }
        if(is_object($handleRequestResponse) && method_exists($handleRequestResponse,'toArray')){
            echo json_encode($handleRequestResponse->toArray());
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

    private function isJson()
    {
        return strpos($_SERVER['HTTP_CONTENT_TYPE'] ?? '', 'application/json')!==FALSE;
    }
}