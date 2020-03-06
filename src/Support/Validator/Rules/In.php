<?php
/**
 * Created by PhpStorm.
 * User: r.ashrafimanesh
 * Date: 11/5/2018
 * Time: 10:18 AM
 */

namespace App\Support\Validator\Rules;


class In extends Rule
{

    private $validValues;
    private $data;
    private $not;
    private $validationStatus;

    public function __construct($data, $validValues, $not = false)
    {
        $this->data = $this->toArray($data);
        $this->not = $not;
        $this->validValues = $validValues;
    }

    function isValid($field): bool
    {
        if(!($this->data[$field] ?? false)){
            $this->validationStatus = false;
        }
        else{
            $in_array = in_array($this->data[$field], $this->validValues);
            $this->validationStatus = $this->not ? !$in_array : $in_array;
        }

        return $this->validationStatus;
    }

    function getMessage($field): string
    {
        return 'The '.$field.' values have to in ['.implode(",",$this->validValues).']';
    }

    function canContinue(): bool
    {
        return $this->validationStatus;
    }
}