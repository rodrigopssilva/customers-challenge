<?php

$factory->define(App\Models\Country::class, function (Faker\Generator $faker) {
    return [
        'code' => strtoupper($faker->lexify('??')),
        'name' => $faker->country,
    ];
});
