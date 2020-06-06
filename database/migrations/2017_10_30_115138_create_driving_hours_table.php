<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrivingHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driving_hours', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamp('start')->nullable(); // time of last engine start
          $table->integer('duration')->default(0); // duration in minute
          $table->string('device_id');
          $table->string('car_id');
          $table->timestamp('when');
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
        Schema::drop('driving_hours');
    }
}
