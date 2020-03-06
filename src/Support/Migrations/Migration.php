<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 11:48 AM
 */

namespace App\Support\Migrations;


use App\Databases\Mysql\MysqlConnection;
use App\Providers\StorageServiceProvider;
use mysqli;

class Migration
{
    protected $migrations_dir;
    /** @var  MysqlConnection */
    protected $db_link;
    protected $tableName='migrations';

    public function __construct(){
        $this->migrations_dir = __DIR__.'/../../migrations';
        //connect to database
        $this->_db();
    }

    public function up(){

        //get list of migrations file.
        $migration_files=dirToArray($this->migrations_dir);
        if(!sizeof($migration_files)){
            die('migration does not exist');
        }

        //check MIGRATION_TABLE_NAME
        $this->_check_table();

        //check run migrations
        $migration_files=$this->_check_run_migrations($migration_files);

        if(sizeof($migration_files)<=0){
            die('migration file does not exist');
        }

        $responses = [];
        foreach($migration_files as $file){
            $responses[] = $this->_run($file,'up');
        }
        return $responses;
    }


    /**
     * @return bool
     */
    public function isMigrationTableExist()
    {
        $tables = $this->db_link->query("SHOW TABLES");
        $table_found = false;
        if ($tables) {
            while ($table = mysqli_fetch_assoc($tables)) {
                if ($table['Tables_in_' . $this->db_link->getDatabaseName()] == $this->tableName) {
                    $table_found = true;
                    break;
                }
            }
            return $table_found;
        }
        return $table_found;
    }

    /**
     * call migration file up or down method
     * @input $file string. migration file name
     * @input $type string. migrate type (up or down)
     */
    private function _run($file,$type='up'){
        require rtrim($this->migrations_dir,'/')."/".$file;
        $x=explode('_',$file);
        $date=$x[0];
        unset($x[0]);
        $class=rtrim(implode('_',$x),'.php');
        $class=new $class();
        switch ($type) {
            case 'down':
                $res=$class->down();
                if($res){
                    $res=$this->db_link->query('DELETE FROM '.$this->tableName." WHERE migrate= '$file' ") or die(mysqli_error($this->db_link));
                    return '<b style="color:green">drop migration: '.$file."<b/><br/>";
                }
                break;
            default:
                $res=$class->up();
                if($res){
                    $res=$this->db_link->query('INSERT INTO '.$this->tableName." VALUES ('$file')") or die(mysqli_error($this->db_link));
                    return '<b style="color:green">run: '.$file."<b/><br/>";
                }
                break;
        }
    }

    private function _db(){
        $this->db_link = StorageServiceProvider::resolveConnection(StorageServiceProvider::STORAGE_MYSQL, 'default');
        if (!$this->db_link) {
            echo "Failed to connect to the database.\n";
            exit;
        }
        $this->db_link->query("SET NAMES 'utf8'");
    }

    private function _check_table($create=true){
        $table_found = $this->isMigrationTableExist();

        if(!$table_found && $create){
            $this->db_link->query("CREATE TABLE `".$this->tableName."` (`migrate` VARCHAR( 255 ) NOT NULL, PRIMARY KEY (  `migrate` )) ENGINE = MYISAM") or die(mysqli_error($this->db_link));
        }
        return $table_found;
    }

    private function _check_run_migrations($migration_files){
        $before_migrations=$this->db_link->query("SELECT * FROM `migrations`");
        if($before_migrations){
            while($db = mysqli_fetch_assoc($before_migrations)) {
                foreach($migration_files as $i=>$file){
                    if($db['migrate']==$file){
                        unset($migration_files[$i]);
                        break;
                    }
                }
            }
        }
        return $migration_files;
    }
}