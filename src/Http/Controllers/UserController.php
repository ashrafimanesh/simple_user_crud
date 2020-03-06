<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 12:40 PM
 */

namespace App\Http\Controllers;


use App\Contracts\iUserRepository;
use App\Entities\UserEntity;
use App\Requests\Request;
use App\Requests\User\UserCreateRequest;
use App\Requests\User\UserDestroyRequest;
use App\Requests\User\UserInfoRequest;
use App\Requests\User\UserUpdateRequest;

class UserController
{
    public function index(iUserRepository $userRepository, Request $request){
        return $userRepository->get();
    }

    public function create(){
        return 'response : '.__METHOD__;
    }

    public function store(iUserRepository $userRepository, UserCreateRequest $request){
        $request->validate();

        $entity = new UserEntity($request->input('first_name'), $request->input('last_name'), $request->input('email'));
        return $userRepository->store($entity);
    }

    public function first(iUserRepository $userRepository){
        return $userRepository->first();
    }

    public function info(iUserRepository $userRepository, UserInfoRequest $request){
        $request->validate();
        return $userRepository->info($request->input('id'));
    }

    public function update(iUserRepository $userRepository, UserUpdateRequest $request){
        $request->validate();
        $entity = new UserEntity($request->input('first_name'), $request->input('last_name'), $request->input('email'));
        $entity->id = $request->input('id');
        return $userRepository->update($entity);
    }

    public function destroy(iUserRepository $userRepository, UserDestroyRequest $request){
        $request->validate();
        $result = $userRepository->delete($request->input('id'));
        return $result ? ['id'=>$request->input('id')] : false;
    }

}