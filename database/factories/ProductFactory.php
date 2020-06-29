<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use FakerRestaurant\Provider\en_US\Restaurant;


$factory->define(Product::class, function (Faker $faker) {
    $faker->addProvider(new Restaurant($faker));
    return [
        'name' => $faker->foodName(),
        'slug'=> $faker->foodName().$faker->unique()->numberBetween(0,1000),
        'description'=> $faker->text(300),
        'price'=> $faker->randomFloat(2,2,1000),
        'status'=> $faker->boolean
    ];
});
