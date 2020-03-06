<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 8:37 PM
 */

namespace App\Providers;


use App\Application;
use App\Contracts\iUserRepository;
use App\Contracts\ServiceProvider;
use App\Databases\Mysql\MysqlConnection;
use App\Databases\Mysql\MysqlQueryBuilder;
use App\Exceptions\DatabaseException;
use App\Storage\Migration\MysqlSchemaTable;
use App\Storage\User\MySqlUserRepository;
use App\Support\Migrations\SchemaTable;

class StorageServiceProvider extends ServiceProvider
{
    const STORAGE_MYSQL='mysql';

    public static function resolveConnection($driver, $connection)
    {
        return Application::resolve(static::makeConnectionAlias($driver, $connection));
    }

    /**
     * @param $driver
     * @param $connection
     * @return string
     */
    public static function makeConnectionAlias($driver, $connection)
    {
        return ucfirst($driver).'Connection' . ucfirst($connection);
    }

    public static function resolveMigration($connection, $table): SchemaTable
    {
        switch(config('database',$connection)['driver']){
            case static::STORAGE_MYSQL:
                return new MysqlSchemaTable($table);
        }
    }

    /**
     * This method call before boot and you can register all providers or alias in this method.
     * @return mixed
     * @internal param Application $app
     */
    public function register()
    {
        $this->app->bind(iUserRepository::class, function()use($app){
            return new MySqlUserRepository(new MysqlQueryBuilder('default'));
        });
    }

    /**
     * Publish some configs or bootstrap actions
     * @return mixed
     * @internal param Application $app
     */
    public function boot()
    {
        foreach($this->app->config('database') as $connection=>$config){
            if($config['driver']==static::STORAGE_MYSQL){
                $this->app->singleton(static::makeConnectionAlias($config['driver'], $connection), function()use($connection,$config){
                    $conn = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['database']);
                    if (!$conn) {
                        $error = mysqli_connect_error();
                        $databaseException = new DatabaseException('Connection failed: ' . $error);
                        $databaseException->setError($error);
                        throw $databaseException;
                    }
                    return (new MysqlConnection($conn,$config));
                });
            }
        }
    }
}