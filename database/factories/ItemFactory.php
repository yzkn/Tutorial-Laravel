<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'title' => $faker->shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_'),
        'content' => $faker->paragraph(),

        'data' => $faker->randomDigit(),
        'confirmed' => $faker->randomElement([true, false]),
        'amount' => $faker->randomFloat(2, 0, 999999),
        'visitor' => $faker->ipv4(),
        'options' => '{"option": "'.$faker->paragraph().'"}',
        'description' => $faker->paragraph(),
        'device' => $faker->macAddress,
        'guid' => $faker->uuid,
    ];
});
