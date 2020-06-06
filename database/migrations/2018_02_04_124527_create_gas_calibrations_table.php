<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateGasCalibrationsTable.
 */
class CreateGasCalibrationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gas_calibrations', function(Blueprint $table) {
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
		Schema::drop('gas_calibrations');
	}
}
