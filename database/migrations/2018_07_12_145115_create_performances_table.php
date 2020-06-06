<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePerformancesTable.
 */
class CreatePerformancesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('performances', function(Blueprint $table) {
            $table->increments('id');
			$table->integer('lat');
			$table->integer('gas');
			$table->integer('deviation');
			$table->string('car_id');
			$table->string('device_id');
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
		Schema::drop('performances');
	}
}
