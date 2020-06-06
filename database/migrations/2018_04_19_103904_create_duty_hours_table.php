<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateDutyHoursTable.
 */
class CreateDutyHoursTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('duty_hours', function(Blueprint $table) {
            $table->increments('id');
			$table->timestamp('start');
			$table->timestamp('finish');
			$table->integer('duration');
			$table->timestamp('when');
			$table->string('car_id');
			$table->string('device_id');
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
		Schema::drop('duty_hours');
	}
}
