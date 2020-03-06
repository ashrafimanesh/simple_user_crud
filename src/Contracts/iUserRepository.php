<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 8:48 PM
 */

namespace App\Contracts;


use App\Entities\UserEntity;

interface iUserRepository
{
    const TABLE = 'users';

    public function all();

    public function store(UserEntity $entity);
}