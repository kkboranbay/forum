<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Reply::class, function (Faker $faker) {
    return [
        'thread_id' => factory('App\Thread')->create()->id,
        'user_id' => factory('App\User')->create()->id,
        'body'    => $faker->paragraph
    ];
});
