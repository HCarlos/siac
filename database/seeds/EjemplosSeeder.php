<?php

use App\Models\Catalogos\Afiliacion;
use App\Models\Catalogos\Domicilios\Calle;
use App\Models\Catalogos\Domicilios\Ciudad;
use App\Models\Catalogos\Domicilios\Codigopostal;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Estado;
use App\Models\Catalogos\Domicilios\Localidad;
use App\Models\Catalogos\Domicilios\Municipio;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class EjemplosSeeder extends Seeder
{

    public function run()
    {
        factory(User::class, 150)->create()->each(function ($user) {
            $idrole = rand(3, Role::all()->count());

//            $IdCalle     = rand(1, Calle::all()->count());
//            $IdColonia   = rand(1, Colonia::all()->count());
//            $IdLocalidad = rand(1, Localidad::all()->count());
//            $IdMunicipio = rand(1, Municipio::all()->count());
//            $IdEstado    = rand(1, Estado::all()->count());
//            $IdCPs       = rand(1, Codigopostal::all()->count());
//
//            $Calle       = Calle::find($IdCalle);
//            $Colonia     = Colonia::find($IdColonia);
//            $Localidad   = Localidad::find($IdLocalidad);
//            $Municipio   = Municipio::find($IdMunicipio);
//            $Estado      = Estado::find($IdEstado);
//            $CPs         = Codigopostal::find($IdCPs);

            $user->roles()->attach($idrole);
            $user->permissions()->attach(7);
////            $user->user_adress()->create(
////                [
////                    'calle' => strtoupper($Calle->calle),
////                    'num_ext' => str_random(10),
////                    'colonia' => strtoupper($Colonia->colonia),
////                    'localidad' => strtoupper($Localidad->localidad),
////                    'municipio' => strtoupper($Municipio->municipio),
////                    'estado' => strtoupper($Estado->estado),
////                    'cp' => $CPs->cp,
////                ]
//            );
            $user->user_data_extend()->create();
        });

        factory(Afiliacion::class, 10)->create();
        factory(Codigopostal::class, 50)->create();
        factory(Comunidad::class, 50)->create();
        factory(Colonia::class,100)->create();
        factory(Ubicacion::class,250)->create()->each(function ($Item){
            $Item->calles()->attach($Item->calle_id);
            $Item->colonias()->attach($Item->colonia_id);
            $Item->localidades()->attach($Item->localidad_id);
            $Item->ciudades()->attach($Item->ciudad_id);
            $Item->municipios()->attach($Item->municipio_id);
            $Item->estados()->attach($Item->estado_id);
            $Item->codigospostales()->attach($Item->codigopostal_id);
        });

    }


}
