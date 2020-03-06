<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 9:08 PM
 */

namespace App\Storage\User;


use App\Contracts\iUserRepository;
use App\Databases\Mysql\MysqlQueryBuilder;
use App\Entities\UserEntity;

class MySqlUserRepository implements iUserRepository
{
    /**
     * @var MysqlQueryBuilder
     */
    private $queryBuilder;

    public function __construct(MysqlQueryBuilder $queryBuilder){

        $this->queryBuilder = $queryBuilder;
    }

    public function all()
    {
        return $this->queryBuilder->from(static::TABLE)->get();
    }

    public function store(UserEntity $entity)
    {
        $date = date('Y-m-d H:i:s');
        $entity->id = $this->queryBuilder->from(static::TABLE)->insert([
            'first_name'=>$entity->firstName,
            'last_name'=>$entity->lastName,
            'email'=>$entity->email,
            "created_at"=> $date,
            "updated_at"=> $date,
        ]);
        $entity->created_at = $date;
        $entity->updated_at = $date;
        return $entity;
    }
}