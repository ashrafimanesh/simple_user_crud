<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 10:26 PM
 */

namespace App\Requests\User;


use App\Requests\Request;
use App\Support\Validator\Rules\Required;

class UserInfoRequest extends Request
{
    public function __construct(){
        parent::__construct();
        $this->rules += [
            'id'=>[new Required($this->input())],
        ];
    }

}