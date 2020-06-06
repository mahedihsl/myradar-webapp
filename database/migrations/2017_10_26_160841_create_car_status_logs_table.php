<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarStatusLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_status_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('car_id');
            $table->string('device_id');
            $table->string('action');
            $table->string('action_type');
            $table->string('executed_by');
            $table->string('before.lock_status');
            $table->string('before.engine_status');
            $table->tinyinteger('after.lock_status');
            $table->tinyinteger('after.engine_status');
            $table->string('user_id');
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
        Schema::drop('car_status_logs');
    }
}
