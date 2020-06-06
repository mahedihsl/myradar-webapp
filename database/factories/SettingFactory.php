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
$factory->define(App\Entities\Setting::class, function (Faker\Generator $faker) {
    return [
        'noti_engine' => TRUE,
        'noti_geofence' => TRUE,
        'noti_date' => TRUE,
        'noti_speed' => TRUE,
        'user_id' => null,
    ];
});
