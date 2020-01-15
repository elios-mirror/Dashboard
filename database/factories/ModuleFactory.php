<?php

use Faker\Generator as Faker;

$factory->define(App\Module::class, function (Faker $faker) {
    $user = factory(App\User::class)->create()->first();

    return [
        'title' => $faker->title,
        'name' => $faker->name,
        'repository' => $faker->email,
        'category' => $faker->word,
        'logo_url' => $faker->imageUrl(),
        'publisher_id' => $user->id,
        'description' => $faker->realText($maxNbChars = 40, $indexSize = 1)
    ];
});
