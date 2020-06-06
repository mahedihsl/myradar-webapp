<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function (Blueprint $table) {
           $table->increments('id');
           $table->string('name');
           $table->string('phone');
           $table->string('email')->unique();
           $table->string('password');
           $table->string('nid');
           $table->tinyInteger('type');
           $table->tinyInteger('customer_type'); // private, enterprise, public
           $table->text('note');
           $table->string('curr_car'); // current car
           $table->rememberToken();
           $table->timestamps();
           $table->softDeletes();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
