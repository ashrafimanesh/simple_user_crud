<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 3:13 PM
 */

namespace App\Databases\Mysql;


abstract class QueryBuilder
{
    /**
     * @var MysqlQueryBuilder
     */
    protected $queryBuilder;

    /**
     * MysqlSelectQueryBuilder constructor.
     * @param MysqlQueryBuilder $queryBuilder
     */
    public function __construct(MysqlQueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    abstract public function parse($data);

}