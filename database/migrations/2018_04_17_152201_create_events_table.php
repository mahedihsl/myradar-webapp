<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateEventsTable.
 */
class CreateEventsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table) {
            $table->increments('id');
			$table->string('title');
			$table->text('body');
			$table->unsignedTinyInteger('type'); // engine, gas, fuel etc ...
			$table->unsignedTinyInteger('mode'); // public/private event
			$table->enum('meta');
			$table->enum('cache'); // cached data for future event
			$table->string('car_id');
			$table->string('user_id');
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
		Schema::drop('events');
	}
}
