<?php
/**
 * Copyright (c) 2018. Realizado por Carlos Hidalgo
 */

/**
 * Created by PhpStorm.
 * User: devch
 * Date: 27/11/18
 * Time: 05:50 PM
 */

namespace App\Traits\Catalogos\Domicilio\Ubicacion;


use App\Models\Catalogos\Domicilios\Calle;
use App\Models\Catalogos\Domicilios\Ciudad;
use App\Models\Catalogos\Domicilios\Codigopostal;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Estado;
use App\Models\Catalogos\Domicilios\Municipio;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\User;

trait UbicacionTrait
{

    public static function detachesCalle($calle_id){
        $Ubicacion = Ubicacion::all()->where('calle_id',$calle_id);
        foreach ($Ubicacion as $ubi){
            $ubi->calles()->detach($ubi->calle_id);
        }
        return true;
    }

    public static function attachesCalle($calle_id){
        $Calle   = Calle::find($calle_id);
        $item = [
            'calle' => strtoupper($Calle->calle),
            'calle_id' => $calle_id,
        ];
        $Ubicacion = Ubicacion::all()->where('calle_id',$calle_id);
        foreach ($Ubicacion as $ubi){
            $ubi->update($item);
            $ubi->calles()->attach($calle_id);
        }
        return true;
    }


    public static function detachesColonia($colonia_id){
        $Ubicacion = Ubicacion::query()->where('colonia_id',$colonia_id)->get();
        foreach ($Ubicacion as $ubi){
            $ubi->colonias()->detach($ubi->colonia_id);
            $ubi->comunidades()->detach($ubi->comunidad_id);
            $ubi->ciudades()->detach($ubi->ciudad_id);
            $ubi->municipios()->detach($ubi->municipio_id);
            $ubi->estados()->detach($ubi->estado_id);
            $ubi->codigospostales()->detach($ubi->codigopostal_id);
        }
        return true;
    }

    public static function attachesColonia($colonia_id){
        $Colonia   = Colonia::find($colonia_id);
        if ( is_null($Colonia) ){
            //dd($colonia_id);
            return false;
        }
        $Comunidad = Comunidad::find($Colonia->comunidad_id);
        $CPs       = Codigopostal::find($Colonia->codigopostal_id);

        $item = [
            'colonia' => strtoupper($Colonia->colonia),
            'comunidad' => strtoupper($Comunidad->comunidad),
            'ciudad' => strtoupper($Comunidad->ciudad->ciudad),
            'municipio' => strtoupper($Comunidad->municipio->municipio),
            'estado' => strtoupper($Comunidad->estado->estado),
            'cp' => strtoupper($CPs->cp),
            'comunidad_id' => $Comunidad->id,
            'ciudad_id' => $Comunidad->ciudad_id,
            'municipio_id' => $Comunidad->municipio_id,
            'estado_id' => $Comunidad->estado_id,
            'codigopostal_id' => $CPs->id,
        ];
        $Ubicacion = Ubicacion::query()->where('colonia_id',$colonia_id)->get();

        foreach ($Ubicacion as $ubi){
            $ubi->colonias()->attach($colonia_id);
            $ubi->comunidades()->attach($ubi->comunidad_id);
            $ubi->ciudades()->attach($ubi->ciudad_id);
            $ubi->municipios()->attach($ubi->municipio_id);
            $ubi->estados()->attach($ubi->estado_id);
            $ubi->codigospostales()->attach($ubi->codigopostal_id);
            $ubi->update($item);
//            dd($item);
        }
        return true;
    }








}
