<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('healths', function(Blueprint $table) {

			$table->increments('id');
			$table->unsignedInteger('loop_count');
			$table->unsignedInteger('setup_time');
			$table->unsignedInteger('avg_loop_time');
			$table->unsignedInteger('min_loop_time');
			$table->unsignedInteger('max_loop_time');
			$table->unsignedInteger('min_free_ram');
			$table->unsignedInteger('max_free_ram');
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
		Schema::drop('healths');
	}

}
