<?php

use App\Contracts\iUserRepository;
use App\Support\Migrations\Schema;
use App\Support\Migrations\SchemaTable;
use App\Support\Migrations\Types\BigIntField;
use App\Support\Migrations\Types\StringField;

class create_users_table{
    public function up(){
        return (new Schema('default'))->create(iUserRepository::TABLE, function(SchemaTable $table){
            $table->addField((new BigIntField('id', 20, false, true)));
            $table->addField((new StringField('first_name', 200)));
            $table->addField((new StringField('last_name', 200)));
            $table->addField((new StringField('email', 200)));
            $table->timestamps();
        });
    }
}