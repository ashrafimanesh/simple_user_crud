<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 9:57 PM
 */

namespace App\Databases\Mysql;


use mysqli_result;

class MysqlSelectQueryBuilder
{
    /**
     * @var MysqlQueryBuilder
     */
    private $queryBuilder;

    /**
     * MysqlSelectQueryBuilder constructor.
     * @param MysqlQueryBuilder $queryBuilder
     */
    public function __construct(MysqlQueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }


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
        return <<<SQL
SELECT {$fields} FROM {$this->queryBuilder->getTable()} {$conditions} {$group} {$order}
SQL;
    }

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