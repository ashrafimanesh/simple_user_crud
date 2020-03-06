<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 7:26 PM
 */

namespace App\Databases;


use App\Contracts\iFilterQuery;
use App\Exceptions\InvalidOperandException;
use App\Support\FilterQuery\WhereQuery;

class FilterQuery implements iFilterQuery
{

    public $limit=0,$offset=0;

    protected $first;
    protected $where=[];

    public function first(){
        $this->limit = 1;
        $this->offset = 0;
        $this->first = true;
        return false;
    }

    public function limit():int
    {
        return $this->limit;
    }

    public function offset():int
    {
        return $this->offset;
    }

    public function isFirst():bool
    {
        return $this->first;
    }

    public function where($column, $value, $operand = WhereQuery::OPERAND_EQUAL, $condition = WhereQuery::CONDITION_AND):WhereQuery
    {
        if($operand=='equal'){
            $operand = '=';
        }
        $whereQuery = new WhereQuery($column, $value, $operand, $condition);
        if(!$whereQuery->isValidOperand()){
            throw new InvalidOperandException("Operand ".$operand. " is not valid!");
        }
        $this->where[] = $whereQuery;
        return $whereQuery;
    }

    public function getConditions():array{
        return $this->where;
    }
}