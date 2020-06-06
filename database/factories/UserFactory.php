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
$factory->define(App\Entities\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'phone' => '+88016' . rand(10000000, 99999999),
        'nid' => '' . rand(100000000, 900000000),
        'email' => $faker->unique()->safeEmail,
        'type' => collect([
            App\Entities\User::$TYPE_ADMIN,
            App\Entities\User::$TYPE_AGENT,
            App\Entities\User::$TYPE_GOVT,
            App\Entities\User::$TYPE_OPERATION,
        ])->random(),
        'password' => $password ?: $password = bcrypt('secret'),
        'api_token' => str_random(60),
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\Entities\User::class, 'customer', function($faker) {
    return [
        'address' => $faker->address,
        'type' => App\Entities\User::$TYPE_CUSTOMER,
        'customer_type' => collect([
            App\Entities\User::$CUSTOMER_PRIVATE,
            App\Entities\User::$CUSTOMER_ENTERPRISE,
            App\Entities\User::$CUSTOMER_PUBLIC,
        ])->random(),
    ];
});
