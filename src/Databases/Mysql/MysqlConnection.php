<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 12:27 PM
 */

namespace App\Databases\Mysql;


class MysqlConnection
{
    /**
     * @var \mysqli
     */
    private $conn;
    private $config;

    public function __construct(\mysqli $conn, $config){

        $this->conn = $conn;
        $this->config = $config;
    }

    public function getDatabaseName(){
        return $this->config['database'];
    }

    public function __call($name, $args){
        return call_user_func_array([$this->conn, $name],$args);
    }

    /**
     * @return \mysqli
     */
    public function getConn()
    {
        return $this->conn;
    }
}