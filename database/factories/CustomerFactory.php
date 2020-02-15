<?php

$factory->define(App\Models\Customer::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->e164PhoneNumber,
        'user_id' => \App\Models\User::all()->random()->id,
        'country_id' => \App\Models\Country::all()->random()->id,
    ];
});
