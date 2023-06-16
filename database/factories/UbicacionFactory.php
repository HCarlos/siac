<?php

use App\Models\Catalogos\Domicilios\Calle;
use App\Models\Catalogos\Domicilios\Codigopostal;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Ubicacion;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Ubicacion::class, function (Faker $faker) {

    $IdCalle     = $faker->numberBetween(1, Calle::all()->count());
    $IdColonia   = $faker->numberBetween(1, Colonia::all()->count());

    $Calle       = Calle::find($IdCalle);
    $Colonia     = Colonia::find($IdColonia);
    $Comunidad   = Comunidad::find($Colonia->comunidad_id);
    $CPs         = Codigopostal::find($Colonia->codigopostal_id);

    return [
        'calle' => strtoupper($Calle->calle),
        'num_ext' => Str::random(10),
        'colonia' => strtoupper($Colonia->colonia),
        'comunidad' => strtoupper($Comunidad->comunidad),
        'ciudad' => strtoupper($Comunidad->ciudad->ciudad),
        'municipio' => strtoupper($Comunidad->municipio->municipio),
        'estado' => strtoupper($Comunidad->estado->estado),
        'cp' => $CPs->cp,
        'latitud' => $faker->latitude,
        'longitud' => $faker->longitude,
        'calle_id' => $IdCalle,
        'colonia_id' => $IdColonia,
        'comunidad_id' => $Comunidad->id,
        'ciudad_id' => $Comunidad->ciudad_id,
        'municipio_id' => $Comunidad->municipio_id,
        'estado_id' => $Comunidad->estado_id,
        'codigopostal_id' => $CPs->id,
    ];

});
