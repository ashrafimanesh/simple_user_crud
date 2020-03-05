<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 12:40 PM
 */

namespace App\Http\Controllers;


use App\Requests\Request;

class UserController
{
    public function create(){
        return 'response : '.__METHOD__;
    }

    public function store(Request $request){
        return $request->input();
    }

    public function update(Request $request){
        return $request->input();
    }

    public function destroy(Request $request){
        return $request->input();
    }

}