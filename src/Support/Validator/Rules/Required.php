<?php
/**
 * Created by PhpStorm.
 * User: r.ashrafimanesh
 * Date: 11/5/2018
 * Time: 9:50 AM
 */

namespace App\Support\Validator\Rules;


class Required extends Rule
{

    private $data;
    private $validationStatus;

    public function __construct($data = null)
    {
        $this->data = $this->toArray($data);
    }

    function isValid($field): bool
    {
        if(strpos($field,'.')){
            $fields = explode('.',$field);
            $this->validationStatus = ($this->data[$fields[0]][$fields[1]] ?? false) ? true : false;
        }
        else{
            $this->validationStatus = ($this->data[$field] ?? false) ? true : false;
        }
        return $this->validationStatus;
    }

    function getMessage($field): string
    {
        return "The $field is required!";
    }

    function canContinue(): bool
    {
        return $this->validationStatus;
    }
}