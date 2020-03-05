<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/4/20
 * Time: 8:28 AM
 */

namespace App;


use App\Contracts\iResponse;
use App\Contracts\iRouter;
use App\Contracts\iServiceProvider;

class Application
{

    private static $binders = [];

    protected $facade = [];
    /**
     * @var
     */
    private $providers = [];

    private $singleton = [];
    private $basePath;

    public static function resolve($name, $args = [])
    {
        if(isset(static::$binders[$name])){
            return call_user_func_array(static::$binders[$name], $args);
        }
        return new $name(...$args);
    }

    public function __construct($basePath){
        $this->basePath = $basePath;
    }

    public function facade($array)
    {
        $this->facade += $array;
        return $this;
    }

    public function providers($array)
    {
        $this->providers += $array;
        return $this;
    }

    public function bind($class, $param)
    {
        static::$binders[$class] = $param;
    }

    public function run()
    {
        try{
            $this->registerProviders();
            $this->registerAlias();
            $this->boot();
            static::resolve(iResponse::class)->render(static::resolve(iRouter::class)->handleRequest());
        }catch (\Exception $e){
            (new \ExceptionHandler)->handle($e);
        }
    }

    private function registerAlias()
    {
        foreach($this->facade as $alias=>$class){
            class_alias($class,$alias);
        }
    }

    public function singleton($class, $param)
    {
        $this->bind($class, function()use($class, $param){
            if(!isset($this->singleton[$class])){
                $this->singleton[$class] = call_user_func_array($param,func_get_args());
            }
            return $this->singleton[$class];
        });
    }

    protected function registerRoutes()
    {

    }

    private function registerProviders()
    {
        foreach($this->providers as $provider){
            /** @var iServiceProvider $obj */
            $obj = (new $provider);
            $obj->register($this);
        }
    }

    private function boot()
    {
        foreach($this->providers as $provider){
            /** @var iServiceProvider $obj */
            $obj = (new $provider);
            $obj->boot($this);
        }
    }

}