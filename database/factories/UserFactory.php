<?php

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(User::class, function (Faker $faker) {
    return [
        'ap_paterno' => strtoupper($faker->lastName),
        'ap_materno' => strtoupper($faker->lastName),
        'nombre' => strtoupper($faker->firstName),
        'username' => $faker->unique()->userName,
        'genero' => $faker->numberBetween(0,1),
        'fecha_nacimiento' => $faker->date(),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('secret'),
        'remember_token' => Str::random(10),
    ];
});
