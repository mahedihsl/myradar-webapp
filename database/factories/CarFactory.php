<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Entities\Car::class, function (Faker\Generator $faker) {
    $time = Carbon\Carbon::today();

    return [
        'name' => 'Toyota Corolla',
        'model' => 'MG-06',
        'reg_no' => rand(10, 99) . '-' . rand(1000, 9999),
        'reg_date' => $time->subYears(rand(2, 5)),
        'fitness_date' => $time->subYears(rand(2, 5)),
        'type' => 1,
        'note' => $faker->paragraph,
        'user_id' => null,
    ];
});
