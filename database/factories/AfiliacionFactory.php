<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Catalogos\Afiliacion::class, function (Faker $faker) {
    return [
        'afiliacion' => $faker->unique()->sentence(3),
    ];
});
