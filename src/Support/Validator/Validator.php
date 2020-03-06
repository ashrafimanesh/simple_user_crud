<?php
/**
 * Created by PhpStorm.
 * User: r.ashrafimanesh
 * Date: 11/5/2018
 * Time: 9:46 AM
 */

namespace App\Support\Validator;


use App\Support\Validator\Rules;

class Validator
{

    protected $errors = [];
    protected $fields;
    protected $checkedRules = [];

    public function isValid()
    {
        foreach ($this->fields as $field => $rules) {
            foreach ($rules as $rule) {
                if ($rule instanceof Rules\Rule) {
                    $this->checkRule($rule, $field);
                    if (!$rule->canContinue()) {
                        return sizeof($this->errors) > 0 ? false : true;
                    }
                }
            }
        }
        return sizeof($this->errors) > 0 ? false : true;
    }

    /**
     * @param Rules\Rule $rule
     * @param $field
     * @return bool
     */
    protected function checkRule(Rules\Rule $rule, $field)
    {
        if(!isset($this->checkedRules[$field])){
            $this->checkedRules[$field] = [];
        }
        $isValid = $rule->isValid($field);
        $this->checkedRules[$field][get_class($rule)] = ['validationStatus'=>$isValid,'canContinue'=>$rule->canContinue()];
        if (!$isValid) {
            $message = $rule->getMessage($field);
            if ($message) {
                if (!isset($this->errors[$field])) {
                    $this->errors[$field] = [];
                }
                $this->errors[$field][] = $message;
            }
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getCheckedRules(): array
    {
        return $this->checkedRules;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function setRules($fields){
        $this->fields = $fields;
        return $this;
    }

    public function __toString(){

        $str = '';
        foreach($this->errors as $field=>$error){

            $str.="($field : ".implode(',',$error). "),";
        }
        return rtrim($str,',');
    }

}