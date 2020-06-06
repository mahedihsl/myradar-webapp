<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Entities\District::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});
