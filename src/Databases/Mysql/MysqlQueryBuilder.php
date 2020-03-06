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
    const TYPE_INSERT = 'insert';
    protected $db;
    private $table;
    private $query;

    public function __construct($connection){
        /** @var MysqlConnection $connection */
        $this->db = StorageServiceProvider::resolveConnection(StorageServiceProvider::STORAGE_MYSQL, $connection);
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
        $connection = $this->getDb();

        $builder = $this->getBuilder(static::TYPE_SELECT);
        $this->query = $builder->build();
        return $builder->parse($connection->query($this->query));

    }

    public function insert($data)
    {
        $db = $this->getDb();

        $builder = $this->getBuilder(static::TYPE_INSERT);
        $this->query = $builder->build($data);
        return $builder->parse($db->query($this->query));
    }

    private function getBuilder($type)
    {
        switch($type){
            case static::TYPE_SELECT:
                return new MysqlSelectQueryBuilder($this);
            case static::TYPE_INSERT:
                return new MysqlInsertQueryBuilder($this);
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

    /**
     * @return MysqlConnection
     */
    public function getDb()
    {
        return $this->db;
    }
}