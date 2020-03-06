<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 11:10 AM
 */

namespace App\Support\Migrations;


use App\Support\Migrations\Types\DateTimeField;

abstract class SchemaTable
{
    protected $table;
    protected $fields = [];

    abstract public function create();

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function addField(SchemaField $field)
    {
        $this->fields[] = $field;
        return $this;
    }

    public function timestamps()
    {
        $this->fields[] = new DateTimeField('created_at');
        $this->fields[] = new DateTimeField('updated_at');

    }


//    abstract function create()
}