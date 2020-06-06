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
$factory->define(App\Entities\Device::class, function (Faker\Generator $faker) {
    $prefix = collect(['017', '015', '016', '018', '019']);
    $status = collect([
        App\Entities\Device::$STATUS_ONLINE,
        App\Entities\Device::$STATUS_OFFLINE,
        App\Entities\Device::$STATUS_CUT_OFF,
    ]);

    return [
        'iccid' => $prefix->random() . rand(10000000, 99999999),
        'imei' => rand(10000000, 99999999),
        'com_id' => rand(100000, 999999),
        'system_status' => $status->random(),
        'device_status' => $status->random(),
        'car_id' => null,
        'user_id' => null,
    ];
});
