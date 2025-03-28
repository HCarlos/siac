<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Classes\Denuncia;

use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Illuminate\Support\Facades\Auth;

class VistaDenunciaClass{

    public function __construct(){ }

    public function vistaDenuncia($denuncia_id){

        $den = Denuncia::findOrFail($denuncia_id);

//        dd($den);

        if ($den) {

//                ->select('id','denuncia_id','dependencia_id','servicio_id','estatu_id')
            $dens = Denuncia_Dependencia_Servicio::query()
                ->where('denuncia_id', $denuncia_id)
                ->orderBy('id')
                ->get();

//            dd(count($dens));

//            $arr = [];
//            foreach ($dens as $d1) {
//                $val = $d1->denuncia_id.'|'.$d1->dependencia_id.'|'.$d1->servicio_id.'|'.$d1->estatu_id;
//                if (!in_array($val, $arr, true)){
//                    $arr[] = $val;
//                }
//            }

//            if (count($arr) > 0) {

//            dd( $dens );

            if (count($dens) > 0) {
                $estatus_general = [];
                $estatus_id = $den->estatus_id;
                $servicio_id = $den->servicio_id;
                $dependencia_id = $den->dependencia_id;
                $favorable = false;
                $is_favorable = false;
                $ue_id = 0;

                foreach ($dens as $dds) {
//                    $d1 = explode('|', $valor);
//                    $dds = Denuncia_Dependencia_Servicio::query()
//                        ->where('denuncia_id', (int)$d1[0])
//                        ->where('dependencia_id', (int)$d1[1])
//                        ->where('servicio_id', (int)$d1[2])
//                        ->where('estatu_id', (int)$d1[3])
//                        ->orderByDesc('id')
//                        ->first();
//                    $dds = Denuncia_Dependencia_Servicio::find($valor->id);

                    if ($dds) {
                        $abrev = $dds->dependencia->abreviatura;
                        $estatus = $dds->estatu->estatus;
                        $servicio = $dds->servicio->servicio;
                        $estatus_general[] = array(
                            'denuncia_id' => $dds->denuncia_id,
                            'dependencia_id' => $dds->dependencia_id,
                            'abreviatura' => $abrev,
                            'estatus_id' => $dds->estatu_id,
                            'estatus' => $estatus,
                            'servicio_id' => $dds->servicio_id,
                            'servicio' => $servicio,
                            'favorable' => $dds->favorable,
                            'leida' => $dds->fue_leida,
                            'fecha' => $dds->fecha_movimiento,
                            'creadopor_id' => $dds->creadopor_id,
                            'creado_por' => $dds->creadopor->FullName,
                        );

                        $estatus_id = $dds->estatu_id;
                        $servicio_id = $dds->servicio_id;
                        $dependencia_id = $dds->dependencia_id;

                        $ue_id =  $dds->estatu_id;
                        $due_id = $dds->dependencia_id;
                        $sue_id = $dds->servicio_id;
                        $fecha_ultimo_estatus = $dds->fecha_movimiento;

                        if ($dds->favorable && !$is_favorable){
                            $favorable = $dds->favorable;
                            $is_favorable = true;
                        }
                    }

                }

                if ( $ue_id > 0){

                    $den->estatus_general = json_encode($estatus_general,JSON_UNESCAPED_UNICODE);
                    $den->estatus_id = $estatus_id;
                    $den->servicio_id = $servicio_id;
                    $den->dependencia_id = $dependencia_id;
                    $den->favorable = $favorable;
                    $den->ue_id =  $ue_id;
                    $den->due_id = $due_id;
                    $den->sue_id = $sue_id;
                    $den->fecha_ultimo_estatus = $fecha_ultimo_estatus;
                    $den->modificadopor_id = Auth::user()->id;
                    $den->save();
                }

            }else{

                $abrev = $den->dependencia->abreviatura;
                $estatus = $den->estatu->estatus;
                $servicio = $den->servicio->servicio;

                $estatus_general[] = array(
                    'denuncia_id' => $den->id,
                    'dependencia_id' => $den->dependencia_id,
                    'abreviatura' => $abrev,
                    'estatus_id' => $den->estatus_id,
                    'estatus' => $estatus,
                    'servicio_id' => $den->servicio_id,
                    'servicio' => $servicio,
                    'favorable' => false,
                    'leida' => false,
                    'fecha' => $den->fecha_ingreso,
                    'creadopor_id' => $den->creadopor_id,
                    'creado_por' => $den->creadopor->FullName,
                );
                $den->estatus_general = json_encode($estatus_general, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
                $den->favorable = false;
                $den->ue_id =  $den->estatus_id;
                $den->due_id = $den->dependencia_id;
                $den->sue_id = $den->servicio_id;
                $den->fecha_ultimo_estatus = $den->fecha_ingreso;
                $den->save();

            }

        }

        return $den;

    }



}
