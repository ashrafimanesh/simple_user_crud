<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 10:41 AM
 */

namespace App\Storage\Migration;

use App\Providers\StorageServiceProvider;
use App\Support\Migrations\SchemaField;
use App\Support\Migrations\SchemaTable;
use App\Support\Migrations\Types\BigIntField;
use App\Support\Migrations\Types\DateTimeField;
use App\Support\Migrations\Types\StringField;

class MysqlSchemaTable extends SchemaTable

{
    public function create()
    {
        if(sizeof($this->fields)<=0){
            return '';
        }

        $sql='CREATE TABLE `'.$this->table.'` (';
        $indexes=',';
        /** @var SchemaField $field */
        foreach($this->fields as $field){
            $sql.=trim($this->createSql($field)).',';
            if($field->primary()){
                $indexes.="PRIMARY KEY (`".$field->getField()."`),";
            }
            else if($index = $field->getIndex()){
                switch($index['type']){
                    case SchemaField::INDEX_NORMAL:
                        $indexName = $index['name'] ?? 'idx_'.$field->getField();
                        $direction = $index['direction'] ?? 'ASC';
                        $indexes.=" INDEX `{$indexName}` (`{$field->getField()}` {$direction})";
                        break;
                    case SchemaField::INDEX_UNIQUE:
                        $indexName = $index['name'] ?? 'unique_'.$field->getField();
                        $direction = $index['direction'] ?? 'ASC';
                        $indexes.=" UNIQUE INDEX `{$indexName}` (`{$field->getField()}` {$direction})";
                        break;
                }
            }
        }

        $sql=rtrim($sql,',');
        $indexes=rtrim($indexes,',');
        $sql.=$indexes.');';
        $res = StorageServiceProvider::resolveConnection(StorageServiceProvider::STORAGE_MYSQL,'default')->query($sql);
        return $res;
    }

    private function createSql(SchemaField $field)
    {
        $column = $field->getField();
        $null = $field->nullAble() ? '' : 'NOT NULL';
        switch(true){
            case $field instanceof BigIntField:
                return "`$column` BIGINT($field->length) $null ".($field->primary() ? 'AUTO_INCREMENT' : '');
            case $field instanceof StringField:
                return "`$column` VARCHAR($field->length) $null";
            case $field instanceof DateTimeField:
                return "`$column` DATETIME $null";
        }
    }
}