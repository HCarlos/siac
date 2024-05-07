<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Classes\Denuncia;

use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;

class VistaDenunciaClass{

    public function __construct(){ }

    public function vistaDenuncia($denuncia_id){

        $den = Denuncia::findOrFail($denuncia_id);
        if ( ! $den->cerrado ){
            $estatus_general = "";

            $dens = Denuncia_Dependencia_Servicio::query()
                ->select('denuncia_id','dependencia_id','servicio_id')
                ->where('denuncia_id', $denuncia_id)
                ->distinct()
                ->get();

            foreach ($dens as $d1){
                $dds = Denuncia_Dependencia_Servicio::query()
                    ->where('denuncia_id', $d1->denuncia_id)
                    ->where('dependencia_id', $d1->dependencia_id)
                    ->where('servicio_id', $d1->servicio_id)
                    ->last();
                $abrev = $dds->dependencia->abreviatura;
                $estatus = $dds->estatu->estatus;
                $estatus_general .= $estatus_general === "" ? "" : " | ";
                $estatus_general .= $abrev . " => " . $estatus ;
            }
            $den->estatus_general = $estatus_general;
            $den->save();

        }

    }



}
