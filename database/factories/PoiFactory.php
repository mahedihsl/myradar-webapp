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
$factory->define(App\Entities\Poi::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->address,
        'lat' => 23 + (rand(710000, 880000) / 1000000),
        'lng' => 90 + (rand(340000, 440000) / 1000000),
    ];
});
