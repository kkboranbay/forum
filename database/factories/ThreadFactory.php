<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thread;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return create('App\User')->id;
        },
        'channel_id' => function () {
            return create('App\Channel')->id;
        },
        'title' => $faker->sentence,
        'body'  => $faker->paragraph
    ];
});
