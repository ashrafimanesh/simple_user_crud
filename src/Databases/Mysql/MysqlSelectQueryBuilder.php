<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 9:57 PM
 */

namespace App\Databases\Mysql;


use App\Support\FilterQuery\WhereQuery;
use mysqli_result;

class MysqlSelectQueryBuilder extends QueryBuilder
{
    use MysqlFilterQuery;

    public function build()
    {
        //TODO create fields segment
        $fields = '*';
        //TODO create conditions segment
        $conditions = '';
        //TODO create group segment
        $group = '';
        //TODO create order segment
        $order = '';
        $limit = '';
        if($filter = $this->queryBuilder->getFilter()){
            if($filter->limit()){

                $limit = 'LIMIT '.$filter->limit();
                $limit .= ' OFFSET '.$filter->offset();
            }
            $conditions = $this->makeConditions($filter, $conditions);
        }
        return <<<SQL
SELECT {$fields} FROM {$this->queryBuilder->getTable()} {$conditions} {$group} {$order} {$limit}
SQL;
    }

    /**
     * @param $result
     * @return \App\Support\Collection
     */
    public function parse($result)
    {
        $response = collect([]);
        if (($result instanceof mysqli_result) && ($result->num_rows > 0)) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $response->addItem($row);
            }
        }
        return $response;
    }
}