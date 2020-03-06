<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 10:34 AM
 */

namespace App\Support\Migrations;


use App\Providers\StorageServiceProvider;

class Schema
{
    private $connection;
    private $table;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function create($table,\Closure $callback){
        $schemaTable = StorageServiceProvider::resolveMigration($this->connection, $table);
        $callback($schemaTable);
        return $schemaTable->create();
    }

    public function update($table,\Closure $callback){
//        StorageServiceProvider::resolveMigration($this->connection)->update(...func_get_args());
    }
}