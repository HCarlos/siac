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

namespace App\Traits\Denuncia;


use App\Models\Catalogos\Domicilios\Calle;
use App\Models\Catalogos\Domicilios\Ciudad;
use App\Models\Catalogos\Domicilios\Codigopostal;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Estado;
use App\Models\Catalogos\Domicilios\Municipio;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait DenunciaTrait
{

    public function getFullUbicationAttribute(){
//        return $this->calle.' '.
//            $this->num_ext.' '.
//            $this->num_int.' '.
//            $this->colonia.' '.
//            $this->comunidad.' '.
//            $this->ciudad.' '.
//            $this->municipio.' '.
//            $this->estado.' '.
//            $this->cp;

        $miLoc = trim($this->colonia) == trim($this->comunidad) ? trim($this->colonia) : trim($this->colonia).' '.trim($this->comunidad);
        return $this->calle.' '.
            $this->num_ext.' '.
            $this->num_int.' '.
            $miLoc.' '.
            $this->ciudad;
    }

    public function getFechaIngresoSolicitudAttribute(){
        return Carbon::parse($this->fecha_ingreso)->format('d-m-Y H:i:s');
    }

    public function getFolioDacAttribute(){
        return "DAC-".str_pad($this->id,6,'0',STR_PAD_LEFT)."-".Carbon::parse($this->fecha_ingreso)->format('y');
    }


    public function getUltimoEstatusAttribute(){
        if ( $this->ultimo_estatu_denuncia_dependencia_servicio->count() > 0){
            try {
                if (Auth::user()->isRole('ENLACE')) {
                    $DependenciaIdArray = Auth::user()->DependenciaIdArray;
                    $ret = $this->ultimo_estatu_denuncia_dependencia_servicio
                        ->whereIn('dependencia_id',$DependenciaIdArray)
                        ->sortByDesc('id')
                        ->first()->estatu->estatus;
                }else{
                    $ret = $this->ultimo_estatu_denuncia_dependencia_servicio
                        ->sortByDesc('id')
                        ->first()->estatu->estatus;
                }
                return $ret;
            }catch (\Exception $e){
                return $ret ?? 'NULO';
            }
        }else{
            return 'Error en Denuncia -> Estatus';
        }
    }


    public function getUltimaFechaEstatusAttribute(){
        if ( $this->ultimo_estatu_denuncia_dependencia_servicio->count() > 0){
            try {
                if (Auth::user()->isRole('ENLACE')) {
                    $DependenciaIdArray = Auth::user()->DependenciaIdArray;
                    $FechaMovto = $this->ultimo_estatu_denuncia_dependencia_servicio
                        ->whereIn('dependencia_id', $DependenciaIdArray)
                        ->sortByDesc('id')
                        ->first()->fecha_movimiento;
                }else{
                    $FechaMovto = $this->ultimo_estatu_denuncia_dependencia_servicio
                        ->sortByDesc('id')
                        ->first()->fecha_movimiento;
                }
                return date_format($FechaMovto, 'd-m-Y');
            }catch (\Exception $e){
                return 'NULO';
            }
        }else{
            return 'Error en Denuncia -> Fecha Movimiento';
        }
    }

    public function getUltimaDependenciaAttribute(){
        if ( $this->ultimo_estatu_denuncia_dependencia_servicio->count() > 0){
            try {
                if (Auth::user()->isRole('ENLACE')) {
                    $DependenciaIdArray = Auth::user()->DependenciaIdArray;
                    $ret = $this->ultimo_estatu_denuncia_dependencia_servicio
                        ->whereIn('dependencia_id',$DependenciaIdArray)
                        ->sortByDesc('id')
                        ->first()->dependencia->dependencia;
                }else{
                    $ret = $this->ultimo_estatu_denuncia_dependencia_servicio
                        ->sortByDesc('id')
                        ->first()->dependencia->dependencia;
                }
                return $ret;
            }catch (\Exception $e){
                return $ret ?? 'NULO';
            }
        }else{
            return 'Error en Denuncia -> Estatus';
        }
    }

    public function getUltimoServicioAttribute(){
        if ( $this->ultimo_estatu_denuncia_dependencia_servicio->count() > 0){
            try {
                if (Auth::user()->isRole('ENLACE')) {
                    $DependenciaIdArray = Auth::user()->DependenciaIdArray;
                    $ret = $this->ultimo_estatu_denuncia_dependencia_servicio
                        ->whereIn('dependencia_id',$DependenciaIdArray)
                        ->sortByDesc('id')
                        ->first()->servicio->servicio;
                }else{
                    $ret = $this->ultimo_estatu_denuncia_dependencia_servicio
                        ->sortByDesc('id')
                        ->first()->servicio->servicio;
                }
                return $ret;
            }catch (\Exception $e){
                return $ret ?? 'NULO';
            }
        }else{
            return 'Error en Denuncia -> Estatus';
        }
    }

    public function getUltimaRespuestaAttribute(){
        if ( $this->ultimo_estatu_denuncia_dependencia_servicio->count() > 0){
            try {
                if (Auth::user()->isRole('ENLACE')) {
                    $DependenciaIdArray = Auth::user()->DependenciaIdArray;
                    $ret = $this->ultimo_estatu_denuncia_dependencia_servicio
                        ->whereIn('dependencia_id',$DependenciaIdArray)
                        ->sortByDesc('id')
                        ->first()->observaciones;
                }else{
                    $ret = $this->ultimo_estatu_denuncia_dependencia_servicio
                        ->sortByDesc('id')
                        ->first()->observaciones;
                }
                return $ret;
            }catch (\Exception $e){
                return $ret ?? 'NULO';
            }
        }else{
            return 'Error en Denuncia -> Estatus';
        }
    }

    public function getTotalRespuestasAttribute(){
        $r = $this->denuncia_estatus()->count();
        return $r == 1 ? '' : $r-1;
    }

    public function Ambito(){
        $r = "No Aplica";
        switch ($this->ambito){
            case 1:
                $r = "Urbana";
                break;
            case 2:
                $r = "Rural";
                break;
        }
        return $r;
    }


}
