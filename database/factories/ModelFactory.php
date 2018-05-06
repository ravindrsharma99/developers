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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

// factory app users
$factory->define(App\AppUser::class, function (Faker\Generator $faker) {
    // default password 123456
    $password = 'eyJpdiI6ImwxK05aU0R1UHZcL0doeGxJSzBNdDBRPT0iLCJ2YWx1ZSI6IjdmUSsybkFMRVZ1alNSRnB2WVRxUVE9PSIsIm1hYyI6ImRhZTg4YjkxZDYwMzYzNDE3YTNjM2NkZTMyMjZjYjRmZDk1N2IyYzI1ZDdhNzA4NTJmOTc1NjFhYjJjOTEzNDIifQ==';

    return [
        'firstname' => $faker->name,
        'lastname' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password,
        'fullname' => $faker->name,
        'address' => $faker->address,
    ];
});