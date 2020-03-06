<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 7:39 PM
 */

namespace App\Support\FilterQuery;


use App\Exceptions\InvalidOperandException;

class WhereQuery
{
    const CONDITION_OR = 'OR';
    const CONDITION_AND = 'AND';
    const OPERAND_EQUAL = '=';
    const OPERAND_LIKE = 'like';

    protected $condition;
    private $column;
    private $children;
    /**
     * @var string
     */
    private $operand;
    private $value;

    public function __construct($column, $value, $operand = WhereQuery::OPERAND_EQUAL, $beforeCondition=WhereQuery::CONDITION_AND){

        $this->column = $column;
        $this->value = $value;
        $this->operand = $operand;
        $this->condition = $beforeCondition;
    }

    public function where($column, $value, $operand = WhereQuery::OPERAND_EQUAL, $beforeCondition=WhereQuery::CONDITION_AND){
        $whereQuery = new WhereQuery(...func_get_args());
        if(!$whereQuery->isValidOperand()){
            throw new InvalidOperandException("Operand ".$operand. " is not valid!");
        }
        $this->children[] = $whereQuery;
        return $whereQuery;
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

    public function isValidOperand()
    {
        return in_array($this->operand, [WhereQuery::OPERAND_EQUAL,WhereQuery::OPERAND_LIKE]);
    }
}