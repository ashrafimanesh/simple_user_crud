<?php
/**
 * Created by PhpStorm.
 * User: ashrafimanesh@gmail.com
 * Date: 3/6/20
 * Time: 12:21 PM
 */

namespace App\Http\Controllers;


use App\Support\Migrations\Migration;

class MigrationController
{
    public function up(){
        (new Migration())->up();
    }

    public function checkTable(){
        return (new Migration())->isMigrationTableExist() ? 'yes' : 'no';
    }
}