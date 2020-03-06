<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 11:09 AM
 */

namespace App\Support\Migrations;


class SchemaField
{
    public $length;
    protected $primary = false;
    protected $nullAble = false;
    protected $field;

    public function __construct($field, $length=0, $nullAble = false, $primary = false){

        $this->field = $field;
        $this->length = $length;
        $this->nullAble = $nullAble;
        $this->primary = $primary;
    }

    public function getField()
    {
        return $this->field;
    }

    public function nullAble()
    {
        return $this->nullAble;
    }

    public function primary(){
        return $this->primary;
    }

}