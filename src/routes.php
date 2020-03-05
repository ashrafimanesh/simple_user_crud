<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 10:13 AM
 */

Route::get('/',function(){
    \App\Application::resolve(\App\Support\Response::class)->render('Hey ramin');
});

Route::get('user', 'UserController@create');

Route::post('user', 'UserController@store');

Route::put('user', 'UserController@update');

Route::delete('user', 'UserController@destroy');