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

    /**
     * This method call before boot and you can register all providers or alias in this method.
     * @param Application $app
     * @return mixed
     */
    public function register(Application $app)
    {
        $app->bind(iUserRepository::class, function()use($app){
            return new MySqlUserRepository(new MysqlQueryBuilder(getenv('MYSQL_DATABASE')));
        });

        $app->singleton('MysqlConnection',function(){
            $host = getenv('MYSQL_HOST');
            $user = getenv('MYSQL_USER');
            $pass = getenv('MYSQL_PASSWORD');
            $conn = mysqli_connect($host, $user, $pass);
            if (!$conn) {
                $error = mysqli_connect_error();
                $databaseException = new DatabaseException('Connection failed: ' . $error);
                $databaseException->setError($error);
                throw $databaseException;
            }
            return $conn;
        });
    }

    /**
     * Publish some configs or bootstrap actions
     * @param Application $app
     * @return mixed
     */
    public function boot(Application $app)
    {
    }
}