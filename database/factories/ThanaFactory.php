<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Entities\Thana::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'district_id' => null,
    ];
});
