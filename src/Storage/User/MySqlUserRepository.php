<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 9:08 PM
 */

namespace App\Storage\User;


use App\Application;
use App\Contracts\iFilterQuery;
use App\Contracts\iUserRepository;
use App\Databases\FilterQuery;
use App\Databases\Mysql\MysqlQueryBuilder;
use App\Entities\UserEntity;
use App\Exceptions\NotFoundDataException;

class MySqlUserRepository implements iUserRepository
{
    /**
     * @var MysqlQueryBuilder
     */
    private $queryBuilder;

    public function __construct(MysqlQueryBuilder $queryBuilder){

        $this->queryBuilder = $queryBuilder;
    }

    public function get(iFilterQuery $filterQuery = null)
    {
        if($filterQuery){
            $this->queryBuilder->setFilter($filterQuery);
        }
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

    public function update(UserEntity $entity)
    {
        /** @var FilterQuery $filter */
        $filter = Application::resolve(FilterQuery::class);
        $filter->where('id', $entity->id);
        $record = $this->queryBuilder->setFilter($filter)->from(static::TABLE)->get()->first();
        if(!($record['id'] ?? false)){
            throw new NotFoundDataException("Can't find user with id: ".$entity->id);
        }
        $date = date('Y-m-d H:i:s');
        $result = $this->queryBuilder->setFilter($filter)->from(static::TABLE)->update([
            'first_name'=>$entity->firstName,
            'last_name'=>$entity->lastName,
            'email'=>$entity->email,
            "updated_at"=> $date,
        ]);
        if(!$result){
            return null;
        }
        $entity->created_at = $record['created_at'];
        $entity->updated_at = $date;
        return $entity;
    }

    public function delete($id)
    {
        /** @var FilterQuery $filter */
        $filter = Application::resolve(FilterQuery::class);
        $filter->where('id', $id);
        $record = $this->queryBuilder->setFilter($filter)->from(static::TABLE)->get()->first();
        if(!($record['id'] ?? false)){
            throw new NotFoundDataException("Can't find user with id: ".$id);
        }
        $result = $this->queryBuilder->setFilter($filter)->from(static::TABLE)->delete();
        return $result;
    }

    public function first()
    {
        /** @var FilterQuery $filter */
        $filter = Application::resolve(FilterQuery::class);
        $filter->first();
        $record = $this->queryBuilder->setFilter($filter)->from(static::TABLE)->get()->first();
        if(!($record['id'] ?? false)){
            throw new NotFoundDataException("Can't find user");
        }
        $entity = new UserEntity($record['first_name'], $record['last_name'], $record['email']);
        $entity->id = $record['id'];
        $entity->created_at = $record['created_at'];
        $entity->updated_at = $record['updated_at'];
        return $entity;
    }

    public function info($id)
    {
        /** @var FilterQuery $filter */
        $filter = Application::resolve(FilterQuery::class);
        $filter->where('id', $id);
        $record = $this->queryBuilder->setFilter($filter)->from(static::TABLE)->get()->first();
        if(!($record['id'] ?? false)){
            throw new NotFoundDataException("Can't find user with id: ".$id);
        }
        $entity = new UserEntity($record['first_name'], $record['last_name'], $record['email']);
        $entity->id = $record['id'];
        $entity->created_at = $record['created_at'];
        $entity->updated_at = $record['updated_at'];
        return $entity;
    }
}