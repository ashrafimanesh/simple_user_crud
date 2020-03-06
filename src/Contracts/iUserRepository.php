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

    public function get(iFilterQuery $filterQuery = null);

    public function store(UserEntity $entity);

    public function update(UserEntity $entity);
}