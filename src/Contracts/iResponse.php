<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/5/20
 * Time: 1:55 PM
 */

namespace App\Contracts;


interface iResponse
{

    public function render($handleRequestResponse,$code=200);
}