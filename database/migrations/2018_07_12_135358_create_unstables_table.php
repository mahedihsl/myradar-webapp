<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUnstablesTable.
 */
class CreateUnstablesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('unstables', function(Blueprint $table) {
            $table->increments('id');
			$table->string('device_id');
			$table->integer('deviation');
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
		Schema::drop('unstables');
	}
}
