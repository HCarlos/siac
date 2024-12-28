<?php

global $factory;

use App\Models\Catalogos\Domicilios\Codigopostal;
use Faker\Generator as Faker;

$factory->define(Codigopostal::class, function (Faker $faker) {
    return [
        'codigo' => $faker->numerify("######"),
        'cp'     => $faker->numerify("######"),
    ];
});
