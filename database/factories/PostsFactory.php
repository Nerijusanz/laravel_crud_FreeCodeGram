<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Post;
use App\User;


$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id'=>function() { return User::all()->random();}, //depend on user
        'caption'=>$faker->name
    ];
});
