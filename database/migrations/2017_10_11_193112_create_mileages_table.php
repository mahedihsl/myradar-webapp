t<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMileagesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mileages', function(Blueprint $table) {
      		$table->increments('id');
			$table->float('value');
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
		Schema::drop('mileages');
	}

}
