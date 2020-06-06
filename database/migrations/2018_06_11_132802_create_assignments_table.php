<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAssignmentsTable.
 */
class CreateAssignmentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assignments', function(Blueprint $table) {
            $table->increments('id');
			$table->string('driver_id');
			$table->string('employee_id')->nullable();
			$table->string('car_id');
			$table->string('user_id'); // enterprise user id
			$table->string('start'); // starting address
			$table->string('dest'); // destination address
			$table->string('message')->nullable();
			$table->timestamp('from');
			$table->timestamp('to');
			$table->unsignedTinyInteger('type'); // 1 = employee, 2 = logistics, 3 = other
			$table->unsignedTinyInteger('status'); // 1 = active, 0 = over
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
		Schema::drop('assignments');
	}
}
