<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 9:00 PM
 */

namespace App\Databases\Mysql;


use App\Exceptions\DatabaseException;

class MysqlUpdateQueryBuilder extends QueryBuilder
{
    use MysqlFilterQuery;

    public function build($data){
        $fields="";
        $mysqli = $this->queryBuilder->getDb()->getConn();
        foreach ($data as $field => $value) {
            $fields .= "`$field` = '".mysqli_escape_string($mysqli, $value)."',";
        }
        $fields = rtrim($fields, ',') ;

        $conditions = '';
        if($filter = $this->queryBuilder->getFilter()){
            $conditions = $this->makeConditions($filter, $conditions);
        }
        return <<<SQL
UPDATE {$this->queryBuilder->getTable()} SET {$fields} {$conditions}
SQL;
    }

    public function parse($data)
    {
        if(!$data){
            throw new DatabaseException(mysqli_error($this->queryBuilder->getDb()->getConn()). ' . QUERY:'.$this->queryBuilder->getQuery());
        }
        return $data;
    }
}