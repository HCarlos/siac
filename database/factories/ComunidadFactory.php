<?php

global $factory;

use App\Models\Catalogos\Domicilios\Ciudad;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Estado;
use App\Models\Catalogos\Domicilios\Municipio;
use App\Models\Catalogos\Domicilios\Tipocomunidad;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comunidad::class, function (Faker $faker) {
    $Ciudad      = Ciudad::all()->where('ciudad',env('CIUDAD_DEFAULT'))->first();
    $Municipio   = Municipio::all()->where('municipio',env('MUNICIPIO_DEFAULT'))->first();
    $Estado      = Estado::all()->where('estado',env('ESTADO_DEFAULT'))->first();

    return [
        'comunidad' => strtoupper($faker->sentence()),
        'delegado_id' => $faker->unique()->numberBetween(1, User::all()->count()),
        'tipocomunidad_id' => $faker->numberBetween(1, Tipocomunidad::all()->count()),
        'ciudad_id' => $Ciudad->id,
        'municipio_id' => $Municipio->id,
        'estado_id' => $Estado->id,
    ];
});
