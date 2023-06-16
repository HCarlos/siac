<?php

use App\Models\Catalogos\Domicilios\Codigopostal;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use Faker\Generator as Faker;

$factory->define(Colonia::class, function (Faker $faker) {
    $IdComun = $faker->numberBetween(1, Comunidad::all()->count());
    $Comun   = Comunidad::find($IdComun);
    $IdCPs   = $faker->numberBetween(1, Codigopostal::all()->count());
    $CPs     = Codigopostal::find($IdCPs);
    return [
        'colonia' => strtoupper($faker->unique()->sentence()),
        'cp' => $CPs->cp,
        'altitud' => $faker->numberBetween(1,3500),
        'latitud' => $faker->latitude,
        'longitud' => $faker->longitude,
        'codigopostal_id' => $CPs->id,
        'comunidad_id' => $Comun->id,
        'tipocomunidad_id' => $Comun->tipocomunidad_id,

    ];
});
