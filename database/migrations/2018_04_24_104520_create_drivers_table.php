<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateDriversTable.
 */
class CreateDriversTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('drivers', function(Blueprint $table) {
      $table->increments('id');
			$table->string('name');
			$table->string('phone');
			$table->string('car_id'); // currently asigned car
			$table->string('user_id'); // enterprise user id
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
		Schema::drop('drivers');
	}
}
