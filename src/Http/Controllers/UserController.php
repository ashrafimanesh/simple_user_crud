<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 12:40 PM
 */

namespace App\Http\Controllers;


use App\Contracts\iUserRepository;
use App\Requests\Request;
use App\Requests\User\UserCreateRequest;

class UserController
{
    public function index(iUserRepository $userRepository, Request $request){
        return $userRepository->all();
    }

    public function create(){
        return 'response : '.__METHOD__;
    }

    public function store(iUserRepository $userRepository, UserCreateRequest $request){
        $request->validate();
        return $request->input();
    }

    public function update(Request $request){
        return $request->input();
    }

    public function destroy(Request $request){
        return $request->input();
    }

}