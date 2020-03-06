<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 9:30 PM
 */

namespace App\Databases\Mysql;


use App\Application;
use App\Contracts\iFilterQuery;
use App\Exceptions\DatabaseException;
use App\Providers\StorageServiceProvider;
use mysqli;

class MysqlQueryBuilder
{
    const TYPE_SELECT = 'select';
    const TYPE_INSERT = 'insert';
    const TYPE_UPDATE = 'update';
    protected $db;
    private $table;
    private $query;
    /** @var iFilterQuery */
    private $filter;

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

    /**
     * @return \App\Support\Collection
     * @throws DatabaseException
     */
    public function get()
    {
        $db = $this->getDb();

        $builder = $this->getBuilder(static::TYPE_SELECT);
        $this->query = $builder->build();
        return $builder->parse($db->query($this->query));

    }

    public function insert($data)
    {
        $db = $this->getDb();

        $builder = $this->getBuilder(static::TYPE_INSERT);
        $this->query = $builder->build($data);
        return $builder->parse($db->query($this->query));
    }

    public function update($data)
    {
        $db = $this->getDb();

        $builder = $this->getBuilder(static::TYPE_UPDATE);
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
            case static::TYPE_UPDATE:
                return new MysqlUpdateQueryBuilder($this);
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

    /**
     * @param iFilterQuery $filter
     * @return MysqlQueryBuilder
     */
    public function setFilter(iFilterQuery $filter)
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * @return iFilterQuery|null
     */
    public function getFilter()
    {
        return $this->filter;
    }
}