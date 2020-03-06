<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 9:35 AM
 */

if(!function_exists('dd')){
    function dd($_){
        echo '<pre>';
        var_dump(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,1));
        call_user_func_array('var_dump',func_get_args());
        die;
    }
}

if(!function_exists('collect')){
    function collect(array $input = []){
        return new \App\Support\Collection($input);
    }
}

function config($category, $param, $default = null){
    $config = require __DIR__.'/configs/'.$category.'.php';
    return $param ? ($config[$param] ?? $default) : ($config ?? $default);
}

function dirToArray($dir,$invalidDirs=array('.','..')){
    $scan_result = scandir( $dir );
    $result=array();
    foreach ( $scan_result as $key => $value ) {

        if (in_array($value, $invalidDirs) || is_dir($dir . '/' . $value)) {
            continue;
        }
        $result[]=$value;
    }
    return $result;
}