<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'content' => $faker->text,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ];
});
