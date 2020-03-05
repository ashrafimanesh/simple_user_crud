<?php

/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 3:40 PM
 */
class UserTest extends \TestCase
{
    public function testCreate(){
        $client = (new \GuzzleHttp\Client());
        $request = $client->request('get',getenv('APP_URL').'/user');

        $response = (string) $request->getBody();
        $this->assertEquals($response, 'response : App\Http\Controllers\UserController::create');
    }

    public function testStore(){
        $client = (new \GuzzleHttp\Client());
        $formData = [
            'first_name' => 'Ramin',
            'last_name' => 'Ashrafimanesh'
        ];
        $request = $client->request('post',getenv('APP_URL').'/user',[
            'form_params'=> $formData
        ]);

        $response = json_decode((string) $request->getBody(),true);
        $this->assertEquals($response, $formData);
    }

    public function testUpdate(){
        $client = (new \GuzzleHttp\Client());
        $formData = [
            'id' => '1',
            'first_name' => 'Ramin',
            'last_name' => 'Ashrafimanesh'
        ];
        $request = $client->request('put',getenv('APP_URL').'/user',[
            'form_params'=> $formData
        ]);

        $response = json_decode((string) $request->getBody(),true);
        $this->assertEquals($response, $formData);
    }

    public function testDestroy(){
        $client = (new \GuzzleHttp\Client());
        $formData = [
            'id' => '1',
        ];
        $request = $client->request('delete',getenv('APP_URL').'/user',[
            'form_params'=> $formData
        ]);

        $response = json_decode((string) $request->getBody(),true);
        $this->assertEquals($response, $formData);
    }
}