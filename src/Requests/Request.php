<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 1:17 PM
 */

namespace App\Requests;


class Request
{
    private $data;
    private $uriParameters;

    public function __construct(){
        $this->request_method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->uri_parts = explode('?', $_SERVER['REQUEST_URI'] ?? '', 2);

        if(isset($this->uri_parts[1])){
            parse_str($this->uri_parts[1],$this->uriParameters);
        }

        $post_vars = $_POST;
        if(in_array($this->request_method,['PUT','DELETE'])) {
            parse_str(file_get_contents("php://input"),$post_vars);
        }
        $this->data = $_GET + $post_vars;
    }

    public function input($name = null, $default = null)
    {
        if(!$name){
            return $this->data;
        }
        return isset($this->data[$name]) ? $this->data[$name] : $default;
    }

    public function getRequestMethod()
    {
        return $this->request_method;
    }

    public function getAction()
    {
        return $this->uri_parts[0]!=='/' ? trim($this->uri_parts[0],'/') : '/';
    }
}