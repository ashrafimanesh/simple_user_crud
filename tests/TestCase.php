<?php declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 3:39 PM
 */

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected $app;

    protected function setUp():void
    {
        $this->app  = require dirname(__DIR__).'/src/bootstrap/app.php';
    }
}