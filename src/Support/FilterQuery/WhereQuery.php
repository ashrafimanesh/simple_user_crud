<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 7:39 PM
 */

namespace App\Support\FilterQuery;


class WhereQuery
{
    const CONDITION_OR = 'OR';
    const CONDITION_AND = 'AND';

    protected $condition;
    private $column;
    private $children;
    /**
     * @var string
     */
    private $operand;
    private $value;

    public function __construct($column, $value, $operand = '=', $beforeCondition=WhereQuery::CONDITION_AND){

        $this->column = $column;
        $this->value = $value;
        $this->operand = $operand;
        $this->condition = $beforeCondition;
    }

    public function where($column, $value, $operand = '=', $beforeCondition=WhereQuery::CONDITION_AND){
        $where = new WhereQuery(...func_get_args());
        $this->children[] = $where;
        return $where;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getOperand()
    {
        return $this->operand;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function getCondition()
    {
        return $this->condition;
    }

    public function hasChild()
    {
        return sizeof($this->children) ? true : false;
    }
}