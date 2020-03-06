<?php

/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 3:40 PM
 */
class UserTest extends \TestCase
{
    protected $user = [];

    public function testCreate(){
        $client = (new \GuzzleHttp\Client());
        $request = $client->request('get',getenv('APP_URL').'/user/create');

        $response = json_decode((string) $request->getBody(),true)['data'];
        $this->assertEquals($response, 'response : App\Http\Controllers\UserController::create');
    }

    public function testStore(){
        $client = (new \GuzzleHttp\Client());
        $formData = [
            'first_name' => 'Ramin',
            'last_name' => 'Ashrafimanesh',
            'email'=>'ashrafimanesh@gmail.com'
        ];
        $request = $client->request('post',getenv('APP_URL').'/user',[
            'form_params'=> $formData
        ]);

        $response = json_decode((string) $request->getBody(),true)['data'];

        if(isset($response['id'])){
            unset($response['id']);
        }
        if(isset($response['created_at'])){
            unset($response['created_at']);
        }
        if(isset($response['updated_at'])){
            unset($response['updated_at']);
        }
        $this->assertEquals($response, $formData);
    }

    public function testFirst(){
        $user = $this->getUser();
        $this->assertTrue($user['id'] ? true : false);
    }

    public function testInfo(){
        $user = $this->getUser();
        $client = (new \GuzzleHttp\Client());
        $request = $client->request('get',getenv('APP_URL').'/user/info?id='.$user['id']);

        $response = json_decode((string) $request->getBody(),true)['data'];
        $this->assertEquals($user, $response);
    }

    public function testUpdate(){
        $user = $this->getUser();
        $client = (new \GuzzleHttp\Client());
        $formData = [
            'id' => $user['id'],
            'first_name' => $user['first_name'].' 1',
            'last_name' => $user['last_name'].' 1',
            'email'=>$user['email'].'1'
        ];
        $request = $client->request('put',getenv('APP_URL').'/user',[
            'form_params'=> $formData
        ]);

        $response = json_decode((string) $request->getBody(),true)['data'];
        if(isset($response['created_at'])){
            unset($response['created_at']);
        }
        if(isset($response['updated_at'])){
            unset($response['updated_at']);
        }
        $this->assertEquals($response, $formData);
    }

    public function testDestroy(){
        $user = $this->getUser();
        $client = (new \GuzzleHttp\Client());
        $formData = [
            'id' => $user['id'],
        ];
        $request = $client->request('delete',getenv('APP_URL').'/user',[
            'form_params'=> $formData
        ]);

        $response = json_decode((string) $request->getBody(),true)['data'];
        $this->assertEquals($response, $formData);
    }

    /**
     * @return mixed
     */
    protected function getUser()
    {
        $client = (new \GuzzleHttp\Client());
        $request = $client->request('get', getenv('APP_URL') . '/user/first');

        $user = json_decode((string)$request->getBody(), true)['data'];
        return $user;
    }
}