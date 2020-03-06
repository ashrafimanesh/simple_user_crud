<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 8:48 PM
 */

namespace App\Contracts;


interface iUserRepository
{
    const TABLE = 'users';

    public function all();
}