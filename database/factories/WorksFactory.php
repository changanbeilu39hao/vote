<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Works;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$url = [
    'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
    'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
];


/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Works::class, function (Faker $faker) use ($url) {
    return [
        'name' => $faker->name,
        'url'  => $faker->randomElement($url),
        'group_id' => $faker->numberBetween(1,3),
    ];
});
