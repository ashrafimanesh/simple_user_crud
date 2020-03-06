<?php
/**
 * Created by PhpStorm.
 * User: r.ashrafimanesh
 * Date: 11/5/2018
 * Time: 9:50 AM
 */

namespace App\Support\Validator\Rules;


class Equal extends Rule
{

    private $data;
    private $value;
    private $validationStatus;

    public function __construct($value, $data = null)
    {
        $this->value = $value;
        $this->data = $this->toArray($data);
    }

    function isValid($field): bool
    {
        if(strpos($field,'.')){
            $fields = explode('.',$field);
            $this->validationStatus = isset($this->data[$fields[0]][$fields[1]]) ? ($this->data[$fields[0]][$fields[1]]==$this->value) : false;
        }
        else{
            $this->validationStatus = isset($this->data[$field]) ? ($this->data[$field]==$this->value) : false;
        }
        return $this->validationStatus;
    }

    function getMessage($field): string
    {
        return "The $field must be equal with '".$this->value."'!";
    }

    function canContinue(): bool
    {
        return $this->validationStatus;
    }
}