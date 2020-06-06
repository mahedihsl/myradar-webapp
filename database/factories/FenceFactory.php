<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Entities\Fence::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->address,
        'lat' => 23 + (rand(710000, 880000) / 1000000),
        'lng' => 90 + (rand(340000, 440000) / 1000000),
        'radius' => rand(300, 1500),
        'thana_id' => null,
    ];
});
