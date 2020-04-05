<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => Hash::make('123123'), // password
        'remember_token'    => Str::random(10),
    ];
});
