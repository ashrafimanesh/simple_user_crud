<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 8:37 PM
 */

namespace App\Providers;


use App\Application;
use App\Contracts\iServiceProvider;
use App\Contracts\iUserRepository;
use App\Databases\Mysql\MysqlQueryBuilder;
use App\Exceptions\DatabaseException;
use App\Storage\User\MySqlUserRepository;

class StorageServiceProvider implements iServiceProvider
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

    /**
     * This method call before boot and you can register all providers or alias in this method.
     * @param Application $app
     * @return mixed
     */
    public function register(Application $app)
    {
        $app->bind(iUserRepository::class, function()use($app){
            //TODO check user database driver
            return new MySqlUserRepository(new MysqlQueryBuilder('default'));
        });
    }

    /**
     * Publish some configs or bootstrap actions
     * @param Application $app
     * @return mixed
     */
    public function boot(Application $app)
    {
        foreach($app->config('database') as $connection=>$config){
            if($config['driver']==static::STORAGE_MYSQL){
                $app->singleton(static::makeConnectionAlias($config['driver'], $connection), function()use($connection,$config){
                    $conn = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['database']);
                    if (!$conn) {
                        $error = mysqli_connect_error();
                        $databaseException = new DatabaseException('Connection failed: ' . $error);
                        $databaseException->setError($error);
                        throw $databaseException;
                    }
                    return $conn;
                });
            }
        }
    }
}