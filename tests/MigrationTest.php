<?php
use App\Providers\StorageServiceProvider;
use App\Support\Migrations\Migration;

/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 2:06 PM
 */
class MigrationTest extends TestCase
{
    public function testTable(){
        $client = (new \GuzzleHttp\Client());
        $request = $client->request('get',getenv('APP_URL').'/migration/up');


        $client = (new \GuzzleHttp\Client());
        $request = $client->request('get',getenv('APP_URL').'/migration/exist');
        $response = (string) $request->getBody();
        $this->assertEquals($response,'yes');

    }
}