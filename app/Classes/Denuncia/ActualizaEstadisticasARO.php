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
use DateTime;
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

        public static function semaforo_ultimo_estatus_off($ue_id, $fecha_mayor, $fecha_menor){

            $sem = 1;
            $dias_vencidos = 0;

            $ffin = Carbon::now();
            $ff = now();
            $ff = $ff->setTime(0,0,0);
            $ff = Carbon::parse($ff);
            $ffin = $ff;
            $finicio = $fecha_menor->setTime(0,0,0);

            $cffin = "";

            if ($ue_id === 17 ||
                $ue_id === 20
            ) {
                $finicio = $fecha_menor->setTime(0,0,0);
                $ffin = $fecha_mayor->setTime(0,0,0);
                $cffin = Carbon::parse($fecha_mayor)->format('d-m-Y');
            }

            $finicio = Carbon::parse($finicio);
            $ffin = Carbon::parse($ffin);

            $dias = $ffin->diffInDays($finicio);

            switch ($ue_id) {
                case 16:
                case 19:
                    $ffin = $fecha_mayor->setTime(0,0,0);
                    $fex = $ff->diffInDays($ffin,false);
                    if ($fex >= 0) {
                        $status = "amarillo";
                        $status_i = "yellow";
                        $class_color = 'text-amarillo-semaforo';
                        $sem = 2;
                    } else {
                        $status = "rojo";
                        $status_i = "red";
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
                    $status_i = "green";
                    $sem = 1;
                    $class_color = 'text-verde-semaforo';
                    break;
                default:
                    $status = "amarillo";
                    $status_i = "yellow";
                    $class_color = 'text-amarillo-semaforo';
                    $sem = 2;
                    break;
            }

            return [
                'sem' => $sem,
                'dias' => $dias,
                'status' => $status,
                'status_i' => $status_i,
                'class_color' => $class_color,
                'fecha_fin' => $cffin,
                'dias_vencidos' => $dias_vencidos,
            ];

        }

}
