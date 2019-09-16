<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SubItem;
use Faker\Generator as Faker;

$factory->define(SubItem::class, function (Faker $faker) {
    return [
        'subtitle' => $faker->shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_'),
        'subcontent' => $faker->paragraph(),
    ];
});
