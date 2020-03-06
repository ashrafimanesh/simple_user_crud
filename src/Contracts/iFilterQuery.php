<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 7:10 PM
 */

namespace App\Contracts;


use App\Support\FilterQuery\WhereQuery;

interface iFilterQuery
{
    public function limit():int;
    public function offset():int;
    public function isFirst():bool;

    public function where($column, $value):WhereQuery;

    public function getConditions():array;

}