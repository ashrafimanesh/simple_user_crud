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
use App\Contracts\ServiceProvider;

class Application
{

    private static $binders = [];

    protected $facade = [];

    protected $configs = [];
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
        $this->basePath = rtrim($basePath,'/');
        $this->appPath = __DIR__;
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
            $providers = $this->registerProviders();
            $this->registerAlias();
            $this->boot($providers);
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

    public function config($category, $param = null , $value = null)
    {
        return $param ? ($this->configs[$category][$param] ?? $value) : ($this->configs[$category] ?? $value);
    }

    public function setConfig($category, $values){
        $this->configs[$category] = $values;
        return $this;
    }

    public function basePath($path = null)
    {
        return $this->basePath.($path ? '/'.ltrim($path,'/') : '');
    }

    public function appPath($path = null)
    {
        return $this->appPath.($path ? '/'.ltrim($path,'/') : '');
    }

    private function registerProviders()
    {
        $providers = [];
        foreach($this->providers as $provider){
            /** @var ServiceProvider $obj */
            $obj = (new $provider($this));
            $obj->register();
            $providers[] = $obj;
        }
        return $providers;
    }

    private function boot(array $providers)
    {
        /** @var ServiceProvider $provider */
        foreach($providers as $provider){
            $provider->boot();
        }
    }

}