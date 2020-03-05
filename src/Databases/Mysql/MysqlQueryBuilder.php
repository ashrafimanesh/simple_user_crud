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
use mysqli;

class MysqlQueryBuilder
{
    const TYPE_SELECT = 'select';
    private $table;
    private $dbName;
    private $query;

    public function __construct($dbName){
        $this->dbName = $dbName;
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
        /** @var mysqli $connection */
        $connection = Application::resolve('MysqlConnection');
        $connection->select_db($this->dbName);
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