<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateRefuelFeedsTable.
 */
class CreateRefuelFeedsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('refuel_feeds', function(Blueprint $table) {
            $table->increments('id');
			$table->unsignedTinyInteger('type'); // fuel or gas
			$table->unsignedTinyInteger('method'); // reserve or refuel
			$table->unsignedDecimal('amount');
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
		Schema::drop('refuel_feeds');
	}
}
