<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 3:08 PM
 */

namespace App\Entities;


class UserEntity
{
    public $id;
    public $firstName;
    public $lastName;
    public $email;

    public function __construct($firstName, $lastName, $email){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    /**
     * @param mixed $id
     * @return UserEntity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function toArray(){
        return [
            'id'=>$this->id,
            'first_name'=>$this->firstName,
            'last_name'=>$this->lastName,
            'email'=>$this->email,
            'created_at'=>$this->created_at ?? null,
            'updated_at'=>$this->updated_at ?? null
        ];
    }

}