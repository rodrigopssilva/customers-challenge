<?php

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => $password ?: $password = \Illuminate\Support\Facades\Hash::make('secret'),
        'remember_token' => \Illuminate\Support\Str::random(10),
    ];
});
