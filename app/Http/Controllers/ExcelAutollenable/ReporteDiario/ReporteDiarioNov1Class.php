<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\ExcelAutollenable\ReporteDiario;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReporteDiarioNov1Class{

    public $vectorServicios;
    protected $ServiciosPrincipales;
    protected $ArrSolicitudesIRValue;
    protected $arrCoorDR;

    protected $vectorOrigenes;

    protected $arrayOrigenes;


    public function __construct(){
        // Inicializar como colección
        $this->vectorServicios = collect([
            ['sue_id' => 483, 'Servicio' => 'BACHEO', 'R' => 0, 'A' => 0],
            ['sue_id' => 508, 'Servicio' => 'DESAZOLVE DE DRENAJE', 'R' => 0, 'A' => 0],
            ['sue_id' => 476, 'Servicio' => 'FUGA DE AGUA', 'R' => 0, 'A' => 0],
            ['sue_id' => 503, 'Servicio' => 'RECOLECCIÓN DE RESIDUOS SÓLIDOS', 'R' => 0, 'A' => 0],
            ['sue_id' => 479, 'Servicio' => 'ALCANTARILLA', 'R' => 0, 'A' => 0],
            ['sue_id' => 466, 'Servicio' => 'LUMINARIAS', 'R' => 0, 'A' => 0],
        ]);

        $this->ServiciosPrincipales = [483, 508, 476, 503, 479, 466];

        $this->vectorOrigenes = collect([
            ['origen_id' => 29, 'Origen' => 'ATENCION DIRECTA SAS', 'T' => 0],
            ['origen_id' => 27, 'Origen' => 'TELEFONO SAS', 'T' => 0],
            ['origen_id' => 25, 'Origen' => 'VENTANILLA cmsm', 'T' => 0],
            ['origen_id' => 28, 'Origen' => 'TELEFONO 072', 'T' => 0],
            ['origen_id' => 3,  'Origen' => 'TELEREPORTAJE', 'T' => 0],
            ['origen_id' => 0,  'Origen' => 'OTROS', 'T' => 0],
        ]);
        $this->arrayOrigenes = [29,27,25,28,3,0];

        // Asegurar que estas propiedades sean colecciones
        $this->arrCoorDR             = collect([]); // Inicializar con tus valores reales

    }

    public function getRecibidas($start_date,$end_date){

        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr =  DB::table("_vimov_sm_nov")
                ->select(DB::raw('COUNT(ue_id) AS suma_ue_id'),'sue_id','ue_id')
                ->where('sue_id', $value)
                ->whereBetween('fecha_ultimo_estatus', [
                    $start_date . ' 00:00:00',
                    $end_date . ' 23:59:59'
                ])
                ->whereIn('ue_id', [19,16])
                ->groupBy('sue_id','ue_id')
                ->get();

            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['R'] = $arr->sum('suma_ue_id');;
                $this->vectorServicios[$key] = $servicio;
            }

        }

        return $this->vectorServicios;

    }

    public function getAtendidas($start_date,$end_date){

        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr =  DB::table("_viddsestatus_nov")
                ->select(DB::raw('COUNT(estatu_id) AS suma_ue_id'),'servicio_id','estatu_id')
                ->where('servicio_id', $value)
                ->whereIn('estatu_id', [17])
                ->where('fecha_movimiento', '>=', $start_date." 00:00:00")
                ->where('fecha_movimiento', '<=', $end_date." 23:59:59")
                ->groupBy('servicio_id','estatu_id')
                ->get();
            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['A'] = $arr[0]->suma_ue_id;
                $this->vectorServicios[$key] = $servicio;
            }
        }

        return $this->vectorServicios;

    }

    public function getOrigenes($start_date,$end_date){

        // 1. Consulta única agrupada por origen_id
        $resultado = DB::table('_vimov_sm_nov')
            ->select('origen_id', DB::raw('COUNT(id) AS suma_id'))
            ->whereBetween('fecha_ultimo_estatus', [
                $start_date . ' 00:00:00',
                $end_date . ' 23:59:59'
            ])
            ->whereIn('origen_id', array_filter($this->arrayOrigenes)) // quita ceros
            ->groupBy('origen_id')
            ->get()
            ->keyBy('origen_id'); // colección indexada por origen_id

        // 2. Actualizar vectorOrigenes correctamente (Laravel 7)
        foreach ($this->arrayOrigenes as $key => $value) {
            if ($value > 0) {
                $fila = $this->vectorOrigenes->get($key);  // ← obtenemos el elemento
                $fila['T'] = $resultado->has($value)
                    ? $resultado[$value]->suma_id
                    : 0;

                $this->vectorOrigenes->put($key, $fila);   // ← lo volvemos a meter
            }
        }

        $total = DB::table('_vimov_sm_nov')
            ->whereBetween('fecha_ultimo_estatus', [
                $start_date . ' 00:00:00',
                $end_date . ' 23:59:59'
            ])
            ->whereNotIn('origen_id', $this->arrayOrigenes)
            ->count('id');

            $origenes = $this->vectorOrigenes[5];
            $origenes['T'] = $total;
            $this->vectorOrigenes[5] = $origenes;

        return $this->vectorOrigenes;

    }


    public function getRecibidasAtendidas($start_date,$end_date): Collection{

        $this->arrCoorDR = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['DELEGADOS', 'COORDINACION_DE_DELEGADOS']);
        })
        ->pluck('id');

        $geo =  DB::table("_viddss")
            ->select('sue_id','ue_id','ciudadano_id','fecha_ultimo_estatus','creadopor_id','fecha_ingreso')
            ->whereIn('sue_id', $this->ServiciosPrincipales)
            ->where('ambito_dependencia', 2)
            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
            ->get();

        foreach($geo as $g){
            $this->setAsigndata($g->sue_id,$g->ciudadano_id,$g->ue_id,$end_date,$g->fecha_ultimo_estatus, $g->creadopor_id, $g->fecha_ingreso);
        }

        $this->getDiasAtrasPorServicio($end_date);

        return $this->vectorServicios;
    }

    private function setAsigndata($sue_id, $ciudadano_id, $ue_id, $end_date,$fecha_ultimo_estatus, $creadopor_id,$fecha_ingreso){

        $fecha_ultimo_estatus = Carbon::parse($fecha_ultimo_estatus)->format('Y-m-d');
        $fecha_ingreso = Carbon::parse($fecha_ingreso)->format('Y-m-d');
        $index = $this->vectorServicios->search(function ($item) use ($sue_id) {
            return $item['sue_id'] == $sue_id;
        });

        if ($index === false) return false;

        $servicio = $this->vectorServicios[$index];


        if ($ue_id === 17 && $fecha_ingreso === $fecha_ultimo_estatus) {
//            dd($fecha_ingreso,$fecha_ultimo_estatus,"IA");
            if ($this->ArrSolicitudesIRValue->contains($ciudadano_id)) {
                $servicio['IA']++;
                $servicio['IR']++;
            } elseif ($this->arrCoorDR->contains($creadopor_id)) {
                $servicio['DA']++;
                $servicio['DR']++;
            } else {
                $servicio['CA']++;
                $servicio['CR']++;
            }
            $servicio['TA']++;
            $servicio['TR']++;
        }else{
            if ($this->ArrSolicitudesIRValue->contains($ciudadano_id)) {
                $servicio['IR']++;
            } elseif ($this->arrCoorDR->contains($creadopor_id)) {
                $servicio['DR']++;
            } else {
                $servicio['CR']++;
            }
            $servicio['TR']++;
        }

        $this->vectorServicios[$index] = $servicio;

        return true;
    }

    public function getDiasAtrasPorServicio($start_date): Collection{
        $start_date0 = $start_date;
        for ($i=0;  $i<6; $i++){
            $servicio = $this->vectorServicios[$i];
            $start_date = Carbon::parse($start_date0)->subDay()->format('Y-m-d');
                for ($j=0;  $j<6; $j++){

                    $geo = DB::table("_viddss")
                        ->select('ue_id','sue_id','fecha_ultimo_estatus','fecha_ingreso')
                        ->where('sue_id', $this->vectorServicios[$i]['sue_id'])
                        ->where('ambito_dependencia', 2)
                        ->whereBetween('fecha_ingreso',[$start_date." 00:00:00", $start_date." 23:59:59"])
                        ->get();
                        $servicio["DIAS_ATRAS"][] = $this->setAsignEstatus($geo, $start_date);
                        $start_date = Carbon::parse($start_date)->subDay()->format('Y-m-d');
                }
            $this->vectorServicios[$i] = $servicio;
        }
        return $this->vectorServicios;
    }

    private function setAsignEstatus($geo,$start_date){

        $atendidas = 0;
        $rechazadas = 0;
        $pendientes = 0;
//        $sue_id = 0;
        foreach ($geo as $g) {
            $fecha_ultimo_estatus = Carbon::parse($g->fecha_ultimo_estatus)->format('Y-m-d');
            $fecha_ingreso = Carbon::parse($g->fecha_ingreso)->format('Y-m-d');
//            if ($g->fecha_ingreso === $g->fecha_ultimo_estatus) {
                switch ($g->ue_id) {
                    case 6:
                    case 17:
                    case 21:
                        $atendidas++;
                        break;
                    case 18:
                    case 20:
                    case 22:
                        $rechazadas++;
                        break;
                    case 16:
                    case 19:
                        $pendientes++;
                        break;
//                }
            }
//            $sue_id = $g->sue_id;
        }
        return ["fecha" => Carbon::parse($start_date)->format('Y-m-d'), "atendidas" => $atendidas, "rechazadas" => $rechazadas, "pendientes" => $pendientes];
    }



}
