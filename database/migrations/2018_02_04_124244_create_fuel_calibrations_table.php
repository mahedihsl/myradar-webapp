<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFuelCalibrationsTable.
 */
class CreateFuelCalibrationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fuel_calibrations', function(Blueprint $table) {
            $table->increments('id');
			$table->collection('data');
			$table->string('device_id');
			$table->string('car_id');
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
		Schema::drop('fuel_calibrations');
	}
}
