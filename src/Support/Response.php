<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 1:57 PM
 */

namespace App\Support;


use App\Contracts\iResponse;
use App\DataModels\BaseResponse;

class Response implements iResponse
{

    public function render($handleRequestResponse, $code=200)
    {
        //TODO handle response headers and response type

        header('Content-Type:application/json');
        if(is_object($handleRequestResponse) && method_exists($handleRequestResponse,'toArray')){
            $baseResponse = new BaseResponse($handleRequestResponse->toArray(),$code);
        }
        else{
            $baseResponse = new BaseResponse($handleRequestResponse, $code);
        }

        echo json_encode($baseResponse);
        exit;
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