<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Classes\Denuncia;

use App\Events\DenunciaAtendidaEvent;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Carbon\Carbon;
use Google\Service\Adsense\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActualizaEstadisticasARO{

    public function __construct(){ }

    public function ActualizaEstadisticasARO($denuncia_id){

        $den = Denuncia::findOrFail($denuncia_id);

        if ($den) {

            $dens = Denuncia_Dependencia_Servicio::query()
                ->select('id','denuncia_id','dependencia_id','servicio_id','estatu_id','fecha_movimiento')
                ->where('denuncia_id', $denuncia_id)
                ->orderBy('id')
                ->get();


            if (count($dens) > 0) {
                foreach ($dens as $d) {
                    if ( in_array($d->estatu_id, [17, 20]) ) {
//                        Log::alert("Evento: ".$d->denuncia_id." ".$d->dependencia_id." ".$d->servicio_id." ".$d->estatu_id);
                        event(new DenunciaAtendidaEvent($d->denuncia_id, 1, 1, $d->estatu_id, false, $d));
                    }
                }
            }


        }

    }

        public function semaforo_ultimo_estatus_off($den, $viDen){

            $sem = 1;

            $finicio = Carbon::now();
            $ffin = Carbon::parse($den->fecha_ingreso);
            $cffin = "";

//            dd($viDen->estatu_id);

            if ($viDen->estatu_id === 17 ||
                $viDen->estatu_id === 20
            ) {
                $finicio = Carbon::parse($den->fecha_ingreso);
                $ffin = Carbon::parse($viDen->fecha_movimiento);
                $cffin = Carbon::parse($viDen->fecha_movimiento)->format('d-m-Y');
            }

            $dias = $finicio->diffInDays($ffin);

            switch ($den->ue_id) {
                case 16:
                case 19:
                    $fex = Carbon::parse(now())->diffInDays(Carbon::parse($ffin), false);
                    if ($fex >= 0) {
                        $status = "amarillo";
                        $class_color = 'text-amarillo-semaforo';
                        $sem = 2;
                    } else {
                        $status = "rojo";
                        $class_color = 'text-rojo-semaforo';
                        $sem = 3;
                        $dias_vencidos = abs($fex);
                    }
                    break;
                case 17:
                case 20:
                case 21:
                case 22:
                    $status = "verde";
                    $sem = 1;
                    $class_color = 'text-verde-semaforo';
                    break;
                default:
                    $status = "amarillo";
                    $class_color = 'text-amarillo-semaforo';
                    $sem = 2;
                    break;
            }

            return [
                'sem' => $sem,
                'dias' => $dias,
                'class_color' => $class_color,
                'fecha_fin' => $cffin,
            ];

        }

}
