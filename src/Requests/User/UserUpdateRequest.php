<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 7:04 PM
 */

namespace App\Requests\User;


use App\Requests\Request;
use App\Support\Validator\Rules\Required;

class UserUpdateRequest extends Request
{
    public function __construct(){
        parent::__construct();
        $this->rules += [
            'id'=>[new Required($this->input())],
            'first_name' => [new Required($this->input())],
            'last_name' => [new Required($this->input())],
            'email' => [new Required($this->input())],
        ];
    }

}