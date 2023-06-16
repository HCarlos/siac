<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 27/11/18
 * Time: 05:50 PM
 */

namespace App\Traits\Catalogos\Domicilio\Comunidad;


use App\Models\Catalogos\Domicilios\Ciudad;
use App\Models\Catalogos\Domicilios\Estado;
use App\Models\Catalogos\Domicilios\Municipio;
use App\User;

trait ComunidadTrait
{

    public static function findOrImport($comunidad,$user_id,$tipocomunidad_id){
        $obj = static::where('comunidad', trim($comunidad))
            ->where('delegado_id', $user_id)
            ->first();
        if (!$obj) {

            $Ciudad      = Ciudad::all()->where('ciudad',env('CIUDAD_DEFAULT'))->first();
            $Municipio   = Municipio::all()->where('municipio',env('MUNICIPIO_DEFAULT'))->first();
            $Estado      = Estado::all()->where('estado',env('ESTADO_DEFAULT'))->first();

            $obj = static::create([
                'comunidad'        => strtoupper(trim($comunidad)),
                'delegado_id'      => $user_id,
                'tipocomunidad_id' => $tipocomunidad_id,
                'ciudad_id'        => $Ciudad->id ?? 1,
                'municipio_id'     => $Municipio->id ?? 1,
                'estado_id'        => $Estado->id ?? 1,
            ]);
        }
        return $obj;
    }


}
