<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 9:05 AM
 */

return [
    'default'=>[
        'driver'=>\App\Providers\StorageServiceProvider::STORAGE_MYSQL,
        'host' => getenv('MYSQL_HOST'),
        'database'=>getenv('MYSQL_DATABASE'),
        'user' => getenv('MYSQL_USER'),
        'pass' => getenv('MYSQL_PASSWORD'),
    ]
];