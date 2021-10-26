<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Campaign::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->text(50),
        'daily_budget' => $faker->numberBetween($min = 1000, $max = 9000),
        'total_budget' => $faker->numberBetween($min = 10000, $max = 90000),
        'from' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'to' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'campaign_image' => $faker->imageUrl($width = 640, $height = 480)
    ];
});
