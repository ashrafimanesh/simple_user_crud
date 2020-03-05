<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 10:19 AM
 */

namespace App\Routing;


use App\Exceptions\InvalidRouteException;

class Route
{
    private static $routes = [
        'get'=>[],
        'post'=>[],
        'put'=>[],
        'delete'=>[],
    ];

    public static function __callStatic($name, $args){
        $name = static::getMethod($name);
        $line = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]['line'];
        if(sizeof($args)!==2){
            throw new InvalidRouteException("Invalid route in line: $line. Define 2 arguments for each method.");
        }
        $validMethods = array_keys(static::$routes);
        if(!in_array($name, $validMethods)){
            throw new InvalidRouteException("Invalid route in line: $line. Invalid method type `$name`, valid methods (".implode(",",$validMethods).")");
        }
        static::$routes[$name][$args[0]] = $args[1];
    }

    public static function findRoute($method, $action){
        return static::$routes[static::getMethod($method)][$action] ?? null;
    }

    private static function getMethod($name)
    {
        return strtolower($name);
    }
}