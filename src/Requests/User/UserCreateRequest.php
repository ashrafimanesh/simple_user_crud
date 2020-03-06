<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 2:39 PM
 */

namespace App\Requests\User;


use App\Requests\Request;
use App\Support\Validator\Rules\Required;

class UserCreateRequest extends Request
{
    public function __construct(){
        parent::__construct();
        $this->rules += [
            'first_name' => [new Required($this->input())],
            'last_name' => [new Required($this->input())],
            'email' => [new Required($this->input())],
        ];
    }
}