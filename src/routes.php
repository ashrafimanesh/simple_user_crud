<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 10:13 AM
 */

use App\Routing\Route;

Route::get('/',function(){
    \App\Application::resolve(\App\Support\Response::class)->render('Hey ramin');
});

Route::get('migration/up','MigrationController@up');

Route::get('migration/exist','MigrationController@checkTable');

Route::get('user', 'UserController@index');

Route::get('user/create', 'UserController@create');

Route::post('user', 'UserController@store');

Route::put('user', 'UserController@update');

Route::delete('user', 'UserController@destroy');