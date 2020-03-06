<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 3:12 PM
 */

namespace App\Databases\Mysql;


use App\Exceptions\DatabaseException;

class MysqlInsertQueryBuilder extends QueryBuilder
{

    public function build($data)
    {
        $fields = $this->buildFields($data);

        $values = $this->buildValues($data);

        return <<<SQL
INSERT INTO  {$this->queryBuilder->getTable()} {$fields} VALUES  {$values}
SQL;
    }

    public function parse($data)
    {
        if(!$data){
            throw new DatabaseException(mysqli_error($this->queryBuilder->getDb()->getConn()));
        }
        return $this->queryBuilder->getDb()->getConn()->insert_id ?? null;
    }

    /**
     * @param $data
     * @return string
     */
    public function buildValues($data)
    {
        $values = '';
        foreach ($data as $value) {
            $values .= "'".mysqli_escape_string($this->queryBuilder->getDb()->getConn(), $value) . "',";
        }
        $values = rtrim($values, ',');
        return "($values)";
    }

    /**
     * @param $data
     * @return string
     */
    public function buildFields($data)
    {
        $fields="";
        foreach ($data as $field => $value) {
            $fields .= "`$field`,";
        }
        $fields = rtrim($fields, ',') ;
        return "($fields)";
    }
}