<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\ExcelAutollenable\ReporteSemanal;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\_viMovSM;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ReporteSemanalClass{

    public $vectorServicios;
    protected $ServiciosPrincipales;
    protected $ArrSolicitudesIRLabel;
    protected $ArrSolicitudesIRValue;
    protected $arrCoorDR;

    protected $vectorFuentesTotales;
    protected $vectorFuentesUnicos;

    protected $arrMesesDelAno;


    public function __construct(){
        // Inicializar como colección
        $this->vectorServicios = collect([
            ['sue_id' => 476, 'Servicio' => 'FUGA DE AGUA', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => [], 'Total' => 0 ,'PA' => []],
            ['sue_id' => 508, 'Servicio' => 'DESAZOLVE DE DRENAJE', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => [], 'Total' => 0 ,'PA' => []],
            ['sue_id' => 483, 'Servicio' => 'BACHEO', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => [], 'Total' => 0 ,'PA' => []],
            ['sue_id' => 466, 'Servicio' => 'REPARACIÓN DE LUMINARIAS', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => [], 'Total' => 0 ,'PA' => []],
            ['sue_id' => 503, 'Servicio' => 'RECOLECCIÓN DE RESIDUOS SÓLIDOS','CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => [], 'Total' => 0 ,'PA' => []],
            ['sue_id' => 479, 'Servicio' => 'REPARACIÓN DE ALCANTARILLAS', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => [], 'Total' => 0 ,'PA' => []],
        ]);

        $this->ServiciosPrincipales = [476, 508, 483, 466, 503, 479];

        // Asegurar que estas propiedades sean colecciones
        $this->ArrSolicitudesIRValue = collect([508833, 519442]);
        $this->ArrSolicitudesIRLabel = collect(["SAS", "LIMPIA"]);
        $this->arrCoorDR             = collect([]);

        $this->vectorFuentesTotales = collect([
            ['origen_id' => 21, 'Origen' => 'GIRA DE TRABAJO', 'Total' => 0],
            ['origen_id' => 3, 'Origen' => 'TELEREPORTAJE', 'Total' => 0],
            ['origen_id' => 20, 'Origen' => 'COORDINACIÓN DE DELEGADOS', 'Total' => 0],
            ['origen_id' => 1, 'Origen' => 'ATENCIÓN DIRECTA', 'Total' => 0],
            ['origen_id' => 29, 'Origen' => 'ATENCIÓN DIRECTA SAS', 'Total' => 0],
            ['origen_id' => 8, 'Origen' => 'TELÉFONO', 'Total' => 0],
            ['origen_id' => 27, 'Origen' => 'TELÉFONO SAS', 'Total' => 0],
            ['origen_id' => 28, 'Origen' => 'TELÉFONO CMSM', 'Total' => 0],
        ]);

        $this->vectorFuentesUnicos = collect([
            ['origen_id' => 21, 'Origen' => 'GIRA DE TRABAJO', 'Total' => 0],
            ['origen_id' => 3, 'Origen' => 'TELEREPORTAJE', 'Total' => 0],
            ['origen_id' => 20, 'Origen' => 'COORDINACIÓN DE DELEGADOS', 'Total' => 0],
            ['origen_id' => 1, 'Origen' => 'ATENCIÓN DIRECTA', 'Total' => 0],
            ['origen_id' => 8, 'Origen' => 'TELÉFONO', 'Total' => 0],
            ['origen_id' => -1, 'Origen' => 'OTROS MEDIOS', 'Total' => 0],
        ]);

        $this->arrMesesDelAno = FuncionesController::obtenerDiasInicioFinMeses();



    }

    public function getVectorServicios($start_date,$end_date): Collection{

        $this->arrCoorDR = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['DELEGADOS', 'COORDINACION_DE_DELEGADOS']);
        })
        ->pluck('id');

        $geo =  DB::table("_vimov_filter_sm")
            ->select('servicio_id','estatu_id','ciudadano_id','fecha_ultimo_estatus','creadopor_id','fecha_ingreso')
            ->whereIn('servicio_id', $this->ServiciosPrincipales)
            ->where('ambito_dependencia', 2)
            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
            ->get();

        foreach($geo as $g){
            $this->setAsigndata($g->servicio_id,$g->ciudadano_id,$g->estatu_id,$end_date,$g->fecha_ultimo_estatus, $g->creadopor_id, $g->fecha_ingreso);
        }

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

    public function getVectorFuentes($start_date,$end_date): Collection{

        $origenIds = $this->vectorFuentesTotales->pluck('origen_id')->toArray();

        $fte =  DB::table("_viddss")
            ->select('origen_id','fecha_ingreso')
            ->whereIn('servicio_id', $this->ServiciosPrincipales)
            ->where('ambito_dependencia', 2)
            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
            ->get();

        $conteoPorOrigen = $fte->groupBy('origen_id')->map->count();

        $this->vectorFuentesTotales = collect([
            ['origen_id' => 21, 'Origen' => 'GIRA DE TRABAJO', 'Total' => 0],
            ['origen_id' => 3, 'Origen' => 'TELEREPORTAJE', 'Total' => 0],
            ['origen_id' => 20, 'Origen' => 'COORDINACIÓN DE DELEGADOS', 'Total' => 0],
            ['origen_id' => 1, 'Origen' => 'ATENCIÓN DIRECTA', 'Total' => 0],
            ['origen_id' => 29, 'Origen' => 'ATENCIÓN DIRECTA SAS', 'Total' => 0],
            ['origen_id' => 8, 'Origen' => 'TELÉFONO', 'Total' => 0],
            ['origen_id' => 27, 'Origen' => 'TELÉFONO SAS', 'Total' => 0],
            ['origen_id' => 28, 'Origen' => 'TELÉFONO CMSM', 'Total' => 0],
            ['origen_id' => -1, 'Origen' => 'OTROS MEDIOS', 'Total' => 0],
        ])->map(function ($item) use ($conteoPorOrigen) {
            $item['Total'] = $conteoPorOrigen->get($item['origen_id'], 0);
            return $item;
        });

        $this->vectorFuentesUnicos = collect([
            ['origen_id' => 21, 'Origen' => 'Gira de trabajo', 'Total' => 0],
            ['origen_id' => 3, 'Origen' => 'Telereportaje', 'Total' => 0],
            ['origen_id' => 20, 'Origen' => 'Coordinación de Delegados', 'Total' => 0],
            ['origen_id' => 1, 'Origen' => 'Atención directa', 'Total' => 0],
            ['origen_id' => 8, 'Origen' => 'Teléfono', 'Total' => 0],
            ['origen_id' => -1, 'Origen' => 'Otros medios', 'Total' => 0],
        ]);

        $mapeoAgrupacion = [
            21 => 21,
            3 => 3,
            20 => 20,
            1 => 1,
            29 => 1,
            8 => 8,
            27 => 8,
            28 => 8,
        ];

// Sumamos los totales según el mapeo
        foreach ($this->vectorFuentesTotales as $fuente) {
            if (isset($mapeoAgrupacion[$fuente['origen_id']])) {
                $idDestino = $mapeoAgrupacion[$fuente['origen_id']];

                $key = $this->vectorFuentesUnicos->search(function ($item) use ($idDestino) {
                    return $item['origen_id'] === $idDestino;
                });

                if ($key !== false) {
                    $currentTotal = $this->vectorFuentesUnicos->get($key)['Total'] ?? 0;
                    $this->vectorFuentesUnicos->put($key, [
                        'origen_id' => $idDestino,
                        'Origen' => $this->vectorFuentesUnicos->get($key)['Origen'],
                        'Total' => $currentTotal + $fuente['Total']
                    ]);
                }
            }
        }

        $vectorFuentesTotales = $this->vectorFuentesTotales;
        $this->vectorFuentesUnicos = $this->vectorFuentesUnicos->map(function ($item) use ($vectorFuentesTotales, $mapeoAgrupacion) {
            $idsToSum = collect($mapeoAgrupacion)->filter(fn($id) => $id === $item['origen_id'])->keys();
            $totalSumado = $vectorFuentesTotales->whereIn('origen_id', $idsToSum)->sum('Total');
            $item['Total'] = $totalSumado;
            return $item;
        });

        $cuantos = 0;
        foreach ($fte as $f) {
            if ( ! in_array( $f->origen_id, $origenIds ) ) {
                $cuantos++;
            }
        }

        $item = $this->vectorFuentesUnicos->get(5);
        if ($item) {
            $item['Total'] = $cuantos;
            $this->vectorFuentesUnicos->put(5, $item);
        }
        return $this->vectorFuentesUnicos->sortBy('Total')->values();

    }

    public function getDiasAtrasPorServicio($start_date,$end_date): Collection{

        for ($i=0;  $i<6; $i++){
            $servicio = $this->vectorServicios[$i];
            for ($j=0;  $j<6; $j++){

                $geo = DB::table("_vimov_filter_sm")
                    ->select('estatu_id','servicio_id','fecha_ultimo_estatus','fecha_ingreso')
                    ->where('servicio_id', $this->vectorServicios[$i]['sue_id'])
                    ->where('ambito_dependencia', 2)
                    ->whereBetween('fecha_ingreso',[$start_date." 00:00:00", $end_date." 23:59:59"])
                    ->get();
                $servicio["DIAS_ATRAS"][] = $this->setAsignEstatus($geo, $start_date);
            }
            $srv = Servicio::find($this->vectorServicios[$i]['sue_id']);
            $ate = round(($srv->promedio_dias_atendida + $srv->promedio_dias_rechazada + $srv->promedio_dias_observada),0);
            $servicio["PA"] = ["atendidas"=>number_format($ate,0),"pendientes"=>number_format((100 - $ate),0)];
            $this->vectorServicios[$i] = $servicio;


        }

//        dd($this->vectorServicios);

        return $this->vectorServicios;
    }

    private function setAsignEstatus($geo,$start_date){

        $atendidas = 0;
        $rechazadas = 0;
        $pendientes = 0;
        $observadas = 0;
        foreach ($geo as $g) {
            switch ($g->estatu_id) {
                case 6:
                case 17:
                case 21:
                    $atendidas++;
                    break;
                case 18:
                    $observadas++;
                    break;
                case 20:
                case 22:
                    $rechazadas++;
                    break;
                case 16:
                case 19:
                    $pendientes++;
                    break;
            }
        }
        return ["fecha" => Carbon::parse($start_date)->format('Y-m-d'), "atendidas" => $atendidas, "rechazadas" => $rechazadas, "pendientes" => $pendientes, "observadas" => $observadas];
    }

    function getTotalServiciosPorMes($start_date,$end_date){

        $meses = $this->arrMesesDelAno;
        $mesActual = Carbon::now()->month;

        foreach ($meses as &$mes) {
            $mes['totales'] = [];
            $mes['total_general'] = 0; // Acumulador global
        }
        $i = 1;
        foreach ($meses as &$mes) {
            if ($i <= ($mesActual - 1)){

                $totalMes = 0; // acumulador para ese mes
                foreach ($this->vectorServicios as $servicio) {
                    $data = _viMovSM::query()
                        ->select(
                            'servicio_id',
                            DB::raw('COUNT(id) as total')
                        )
                        ->where('servicio_id', $servicio['sue_id'])
                        ->where('ambito_dependencia', 2)
                        ->whereBetween('fecha_ingreso', [$mes['inicio']." 00:00:00", $mes['fin']." 23:59:59"])
                        ->groupBy('servicio_id')
                        ->first(); // Solo necesitamos un resultado por servicio

                    $cantidad = $data ? (int)$data->total : 0;

                    $mes['totales'][$servicio['Servicio']] = $cantidad;

                    $totalMes += $cantidad;
                }
                $mes['total_general'] = $totalMes;
                $i++;
            }

        }

        return $meses;

    }


    function getTotalServiciosPorDelegaciones($start_date,$end_date){

        $cacheKey = '_viddss_completa_delegaciones' . md5( $start_date . $end_date); // Genera una clave de caché única
        $delegaciones = Cache::remember($cacheKey, 60, function () use ($start_date, $end_date) {

            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');

            return DB::table("_viddss_completa")
                ->select('centro_delegacion', DB::raw('count(centro_delegacion) as total'))
                ->where('ambito_dependencia', 2)
                ->whereBetween('fecha_ingreso', [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ])
                ->groupBy('centro_delegacion')
                ->orderByDesc('total')
                ->take(20)
                ->get();
        });
        return $delegaciones;
    }

    function getTotalServiciosPorColonias($start_date,$end_date){

        $cacheKey = '_viddss_completa_colonias' . md5( $start_date . $end_date); // Genera una clave de caché única
        $colonias = Cache::remember($cacheKey, 60, function () use ($start_date, $end_date) {

            $start_date = Carbon::parse($start_date)->format('Y-m-d');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');

            return DB::table("_viddss_completa")
                ->select('centro_colonia', DB::raw('count(centro_colonia) as total'))
                ->where('ambito_dependencia', 2)
                ->whereBetween('fecha_ingreso', [
                    $start_date . " 00:00:00",
                    $end_date . " 23:59:59"
                ])
                ->groupBy('centro_colonia')
                ->orderByDesc('total')
                ->take(15)
                ->get();
        });
        return $colonias;
    }






}
