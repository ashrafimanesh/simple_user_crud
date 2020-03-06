<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 9:30 PM
 */

namespace App\Databases\Mysql;


use App\Application;
use App\Exceptions\DatabaseException;
use App\Providers\StorageServiceProvider;
use mysqli;

class MysqlQueryBuilder
{
    const TYPE_SELECT = 'select';
    private $table;
    private $query;
    private $connection;

    public function __construct($connection){
        $this->connection = $connection;
    }

    /**
     * @param $table
     * @return MysqlQueryBuilder
     */
    public function from($table)
    {
        $this->table = $table;
        return $this;
    }

    public function get()
    {
        /** @var MysqlConnection $connection */
        $connection = StorageServiceProvider::resolveConnection(StorageServiceProvider::STORAGE_MYSQL, $this->connection);

        $builder = $this->getBuilder(static::TYPE_SELECT);
        $this->query = $builder->build();
        return $builder->parse($connection->query($this->query));

    }

    private function getBuilder($type)
    {
        switch($type){
            case static::TYPE_SELECT:
                return new MysqlSelectQueryBuilder($this);
            default:
                throw new DatabaseException('Invalid query type: '.$type);
        }
    }

    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }
}