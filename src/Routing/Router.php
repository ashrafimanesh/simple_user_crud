<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 9:47 AM
 */

namespace App\Routing;


use App\Application;
use App\Contracts\iRouter;
use App\Exceptions\InvalidRouteException;
use App\Requests\Request;

class Router implements iRouter
{
    private static $httpControllerPrefix='\App\Http\Controllers\\';

    /** @var  Request */
    private $request;
    private $uriParameters = [];

    public function handleRequest()
    {
        /** @var Request $request */
        $this->request = Application::resolve(Request::class);

        $route = Route::findRoute($this->request->getRequestMethod(), $this->request->getAction());
        if(!$route){
            throw new InvalidRouteException('Route not found.');
        }

        if($route instanceof \Closure){
            return call_user_func_array($route, [Application::resolve(Request::class)]);
        }

        if(is_string($route)){
            if(strpos($route,'@')>0){
                list($controllerName,$methodName) = explode('@', $route);
            }
        }

        if(!isset($controllerName) || !isset($methodName)){
            throw new InvalidRouteException('Invalid controller or method.');
        }

        $controller = static::$httpControllerPrefix . $controllerName;


        return call_user_func_array([new $controller,$methodName], $this->resolveMethodArguments($controller, $methodName));
    }

    /**
     * @param $param
     * @return string|void
     */
    protected function resolveMethodArgumentValue(\ReflectionParameter $param)
    {
        if($param->getClass()){
            return Application::resolve($param->getClass()->getName());
        }
        return $this->request->input($param->getName());
    }

    /**
     * @param $controller
     * @param $methodName
     * @return array
     */
    protected function resolveMethodArguments($controller, $methodName)
    {
        $r = new \ReflectionMethod($controller, $methodName);
        $params = $r->getParameters();
        $args = [];
        /** @var \ReflectionParameter $param */
        foreach ($params as $param) {
            $args[] = $this->resolveMethodArgumentValue($param);
        }
        return $args;
    }
}