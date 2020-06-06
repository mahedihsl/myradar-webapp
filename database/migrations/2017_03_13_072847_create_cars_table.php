<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // ex. Toyota Corolla
            $table->string('model'); // ex. MG-06
            $table->string('reg_no');

            $table->timestamp('reg_date');
            $table->timestamp('tax_date');
            $table->timestamp('fitness_date');
            $table->timestamp('insurance_date');
            $table->unsignedSmallInteger('type'); //car, micro, bike etc...
            $table->text('note');

            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cars');
    }
}
