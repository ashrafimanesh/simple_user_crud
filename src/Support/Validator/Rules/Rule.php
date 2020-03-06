<?php
/**
 * Created by PhpStorm.
 * User: r.ashrafimanesh
 * Date: 11/5/2018
 * Time: 9:50 AM
 */

namespace App\Support\Validator\Rules;


abstract class Rule
{

    abstract function isValid($field): bool;

    abstract function getMessage($field): string;

    abstract function canContinue(): bool;

    protected function toArray($data)
    {
        return toArray($data);
    }
}