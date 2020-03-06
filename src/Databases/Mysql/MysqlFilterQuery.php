<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 9:04 PM
 */

namespace App\Databases\Mysql;


use App\Contracts\iFilterQuery;
use App\Support\FilterQuery\WhereQuery;

trait MysqlFilterQuery
{

    /**
     * @param $cond
     * @param $conditions
     * @return array
     */
    protected function makeWhereCondition(WhereQuery $cond, $conditions)
    {
        $column = $cond->getColumn();
        $operand = $cond->getOperand();
        $value = $cond->getValue();
        $condition = $cond->getCondition();
        $valueWhere = $this->makeValueWhere($operand, $value);
        $conditions .= " $condition `$column` $valueWhere";
        return $conditions;
    }

    /**
     * @param $filter
     * @param $conditions
     * @return array|string
     */
    protected function makeConditions(iFilterQuery $filter, $conditions)
    {
        if ($where = $filter->getConditions()) {

            $condition = '';
            foreach ($where as $cond) {
                if ($cond instanceof WhereQuery) {
                    $condition = $cond->getCondition();
                    $conditions = $this->makeWhereCondition($cond, $conditions);
                }
            }
            $conditions = "WHERE " . ltrim(trim($conditions), $condition);
            return $conditions;
        }
        return $conditions;
    }

    /**
     * @param $operand
     * @param $value
     * @return string
     */
    protected function makeValueWhere($operand, $value)
    {
        switch($operand){
            case WhereQuery::OPERAND_LIKE:
                return "$operand '%$value%'";
            case WhereQuery::OPERAND_EQUAL:
            default:
                return "$operand '$value'";
        }
    }

}