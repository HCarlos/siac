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

            $dens = Denuncia_Dependencia_Servicio::query()
                ->select('denuncia_id','dependencia_id','servicio_id','estatu_id')
                ->where('denuncia_id', $denuncia_id)
                ->orderBy('id')
                ->get();

            $arr = [];
            foreach ($dens as $d1) {
                $val = $d1->denuncia_id.'|'.$d1->dependencia_id.'|'.$d1->servicio_id.'|'.$d1->estatu_id;
                if ( array_search($val, $arr) === false ){
                    $arr[] = $val;
                }
            }

//            dd($arr);
            if (count($arr) > 0) {

                $estatus_general = [];
                $estatus_id = $den->estatus_id;
                $servicio_id = $den->servicio_id;
                $dependencia_id = $den->dependencia_id;
                $favorable = false;
                $is_favorable = false;

                foreach ($arr as $valor) {
                    $d1 = explode('|', $valor);
                    $dds = Denuncia_Dependencia_Servicio::query()
                        ->where('denuncia_id', (int)$d1[0])
                        ->where('dependencia_id', (int)$d1[1])
                        ->where('servicio_id', (int)$d1[2])
                        ->where('estatu_id', (int)$d1[3])
                        ->orderByDesc('id')
                        ->first();

                    if ($dds) {
                        $abrev = $dds->dependencia->abreviatura;
                        $estatus = $dds->estatu->estatus;
                        $servicio = $dds->servicio->servicio;
                        //$estatus_general .= $estatus_general === "" ? "" : " | ";
                        $estatus_general[] = array('dependencia_id' => $dds->dependencia_id,
                            'abreviatura' => $abrev,
                            'estatu_id' => $dds->estatu_id,
                            'estatus' => $estatus,
                            'servicio_id' => $dds->servicio_id,
                            'servicio' => $servicio,
                            'favorable' => $dds->favorable);

                        $estatus_id = $dds->estatu_id;
                        $servicio_id = $dds->servicio_id;
                        $dependencia_id = $dds->dependencia_id;
                        if ($dds->favorable && !$is_favorable){
                            $favorable = $dds->favorable;
                            $is_favorable = true;
                        }

                    }

                }
                $den->estatus_general = json_encode($estatus_general,JSON_UNESCAPED_UNICODE);
                $den->estatus_id = $estatus_id;
                $den->servicio_id = $servicio_id;
                $den->dependencia_id = $dependencia_id;
                $den->favorable = $favorable;
                $den->save();
            }
        }
        return $den;

    }



}
