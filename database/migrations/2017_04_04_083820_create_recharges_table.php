<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_id');
            $table->string('phone');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('volume');
            $table->unsignedInteger('consumed');
            $table->unsignedInteger('remained');
            $table->timestamps();
            $table->timestamp('recharged_at');
            $table->timestamp('validity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('recharges');
    }
}
