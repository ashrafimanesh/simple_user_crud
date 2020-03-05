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