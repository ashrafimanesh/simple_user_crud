<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 9:57 PM
 */

namespace App\Databases\Mysql;


use App\Exceptions\DatabaseException;

class MysqlDeleteQueryBuilder extends QueryBuilder
{
    use MysqlFilterQuery;

    public function build(){
        $conditions = '';
        if($filter = $this->queryBuilder->getFilter()){
            $conditions = $this->makeConditions($filter, $conditions);
        }

        return <<<SQL
DELETE FROM {$this->queryBuilder->getTable()} {$conditions}
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