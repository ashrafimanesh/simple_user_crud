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
}