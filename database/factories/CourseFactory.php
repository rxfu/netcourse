<?php

use Faker\Generator as Faker;

$factory->define(App\Course::class, function (Faker $faker) {
	return [
		'name'    => $faker->unique()->word,
		'class'   => $faker->unique()->word,
		'campus'  => $faker->randomLetter,
		'is_used' => false,
	];
});
