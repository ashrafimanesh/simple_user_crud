<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 10:29 PM
 */

namespace App\Support;


class Collection
{
    /**
     * @var array
     */
    private $items;

    public function __construct(array $items = []){
        $this->items = $items;
    }

    public function each(\Closure $callback){
        foreach($this->items as $item){
            $callback($item);
        }
        return $this;
    }

    public function addItem($row)
    {
        $this->items[] = $row;
        return $this;
    }

    public function count(){
        return sizeof($this->items);
    }

    public function toArray(){
        return $this->items;
    }

    public function first()
    {
        return $this->items[0] ?? null;
    }
}