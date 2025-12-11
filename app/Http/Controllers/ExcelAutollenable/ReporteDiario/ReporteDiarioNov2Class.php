<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\ExcelAutollenable\ReporteDiario;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReporteDiarioNov2Class{

    public $vectorServicios;
    protected $ServiciosPrincipales;
    protected $ArrSolicitudesIRValue;
    protected $arrCoorDR;

    protected $vectorOrigenes;

    protected $arrayOrigenes;

    protected $start_date;
    protected $end_date;
    protected $fecha_desde;


    public function __construct($start_date,$end_date){
        // Inicializar como colección
        $this->vectorServicios = collect([
            ['sue_id' => 476, 'Servicio' => 'FUGA DE AGUA', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
            ['sue_id' => 508, 'Servicio' => 'DESAZOLVE DE DRENAJE', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
            ['sue_id' => 479, 'Servicio' => 'ALCANTARILLA', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
            ['sue_id' => 483, 'Servicio' => 'BACHEO', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
            ['sue_id' => 466, 'Servicio' => 'LUMINARIAS', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
            ['sue_id' => 503, 'Servicio' => 'RECOLECCIÓN DE RESIDUOS SÓLIDOS', 'R' => 0, 'A' => 0, "PROM_PEN" => 0, "DIAS_PEN" => 0, "PROM_ATE" => 0, "DIAS_ATE" => 0, "LLAMADAS" => 0, "TOTAL" => 0, "DIAS_PEN_DEL" => 0, "DIAS_ATE_DEL" => 0, "DIAS_PEN_INS" => 0, "DIAS_ATE_INS" => 0],
        ]);

        $this->ServiciosPrincipales = [476, 508, 479, 483, 466, 503];

        $this->vectorOrigenes = collect([
            ['origen_id' => 29, 'Origen' => 'ATENCION DIRECTA SAS', 'T' => 0],
            ['origen_id' => 27, 'Origen' => 'TELEFONO SAS', 'T' => 0],
            ['origen_id' => 25, 'Origen' => 'VENTANILLA CMSM', 'T' => 0],
            ['origen_id' => 28, 'Origen' => 'TELEFONO 072', 'T' => 0],
            ['origen_id' => 3,  'Origen' => 'TELEREPORTAJE', 'T' => 0],
        ]);
        $this->arrayOrigenes = [29,27,25,28,3];

        // Asegurar que estas propiedades sean colecciones
        $this->arrCoorDR             = collect([]); // Inicializar con tus valores reales

        $this->start_date = $start_date. " 00:00:01";
        $this->end_date = $start_date. " 23:59:59";
        $this->fecha_desde = "2025-11-19 00:00:00";

    }

    public function getRecibidas(){


//        foreach ($this->ServiciosPrincipales as $key => $value) {
//            $arr =  DB::table("_vimov_sm_nov")
//                ->select(DB::raw('COUNT(ue_id) AS suma_ue_id'),'sue_id','ue_id')
//                ->where('sue_id', $value)
//                ->whereBetween('fecha_ingreso', [
//                    $start_date . ' 00:00:00',
//                    $end_date . ' 23:59:59'
//                ])
//                ->whereIn('ue_id', [16,19])
//                ->groupBy('sue_id','ue_id')
//                ->get();
//
//            if (!$arr->isEmpty()) {
//                $servicio = $this->vectorServicios[$key];
//                $servicio['R'] = $arr->sum('suma_ue_id');
//                $this->vectorServicios[$key] = $servicio;
//            }
//
//        }

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr =  DB::table("_viddsestatus_nov")
                ->select(DB::raw('COUNT(ue_id) AS suma_ue_id'),'servicio_id','ue_id')
                ->where('fecha_ingreso','>=', $start_date_e)
                ->where('fecha_ingreso','<=', $end_date_e)
                ->where('servicio_id', $value)
                ->whereNotIn('ciudadano_id', [508833, 519442, 513061])
                ->whereNotIn('origen_id', [20])
                ->whereIn('ue_id', [16,17,18,19,20,21,22])
                ->groupBy('servicio_id','ue_id')
                ->get();

            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['TOTAL'] = $arr->sum('suma_ue_id');
                $this->vectorServicios[$key] = $servicio;
            }

        }


        return $this->vectorServicios;
//        $this->getAtendidas($start_date, $end_date);

    }

    public function getAtendidas(){

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr =  DB::table("_viddsestatus_nov")
                ->select(DB::raw('COUNT(estatu_id) AS suma_ue_id'),'servicio_id','estatu_id')
                ->where('servicio_id', $value)
                ->whereIn('estatu_id', [17])
                ->where('fecha_movimiento', '>=', $start_date_e)
                ->where('fecha_movimiento', '<=', $end_date_e)
                ->groupBy('servicio_id','estatu_id')
                ->get();
            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['A'] = $arr[0]->suma_ue_id;
                $this->vectorServicios[$key] = $servicio;
            }
        }

        return $this->vectorServicios;
//        $this->getPendientesProm($start_date, $end_date);

    }

    public function getOrigenes(){

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

        // 1. Consulta única agrupada por origen_id
        $resultado = DB::table('_viddsestatus_nov')
            ->select('origen_id', DB::raw('COUNT(id) AS suma_id'))
            ->where('fecha_ingreso','>=', $start_date_e)
            ->where('fecha_ingreso','<=', $end_date_e)
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

        $total = DB::table('_viddsestatus_nov')
            ->where('fecha_ingreso','>=', $start_date_e)
            ->where('fecha_ingreso','<=', $end_date_e)
            ->whereNotIn('origen_id', [29,27,25,28,3,20])
            ->count('id');

            $origenes = ['origen_id' => 0,  'Origen' => 'Otros', 'T' => 0];
            $origenes['T'] = $total;
            $this->vectorOrigenes[5] = $origenes;

//            dd($this->vectorOrigenes);

        return $this->vectorOrigenes;

    }


    public function getPendientesProm(){

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr =  DB::table("_viddsestatus_nov")
                ->select('id', 'servicio_id', 'estatu_id','fecha_movimiento',
                    DB::raw("DATE_PART('day', '$end_date_e' - fecha_movimiento) AS dias")
                )
                ->where('fecha_ingreso','>=', $start_date_e)
                ->where('fecha_ingreso','<=', $end_date_e)
                ->where('servicio_id', $value)
                ->whereNotIn('ciudadano_id', [508833, 519442, 513061])
                ->whereNotIn('origen_id', [20])
                ->whereIn('ue_id', [16, 18, 19])
                ->get();

            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['PROM_PEN'] =(int) number_format($arr->avg('dias'),0,'.',',');
                $servicio['DIAS_PEN'] = $arr->count('id');
                $this->vectorServicios[$key] = $servicio;
            }
        }
        return $this->vectorServicios;

    }

    public function getAtendidasProm(){

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

        // promedio
        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr = DB::table("_viddsestatus_nov")
                ->select('id', 'servicio_id', 'estatu_id', 'fecha_movimiento',
                    DB::raw("DATE_PART('day', '$end_date_e' - fecha_movimiento) AS dias")
                )
                ->where('fecha_ingreso','>=', $start_date_e)
                ->where('fecha_ingreso','<=', $end_date_e)
                ->where('servicio_id', $value)
                ->whereNotIn('ciudadano_id', [508833, 519442, 513061])
                ->whereNotIn('origen_id', [20])
                ->whereIn('ue_id', [17, 20])
                ->get();

            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['PROM_ATE'] = (int)number_format($arr->avg('dias'), 0, '.', ',');
                $this->vectorServicios[$key] = $servicio;
            }
        }

        // dias
        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr = DB::table("_viddsestatus_nov")
                ->select('id', 'servicio_id', 'estatu_id', 'fecha_movimiento',
                    DB::raw("DATE_PART('day', '$end_date_e' - fecha_movimiento) AS dias")
                )
                ->where('fecha_ingreso','>=', '2025-11-19 00:00:00')
                ->whereBetween('fecha_movimiento',[$start_date_e, $end_date_e])
                ->where('servicio_id', $value)
                ->whereNotIn('ciudadano_id', [508833, 519442, 513061])
                ->whereNotIn('origen_id', [20])
                ->whereIn('estatu_id', [17, 20, 21, 22])
                ->get();

            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['DIAS_ATE'] = $arr->count('id');
                $this->vectorServicios[$key] = $servicio;
            }

        }

        return $this->vectorServicios;

    }

    public function getPendientesPromCiudadano(){

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

//        _vimov_filter_sm
        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr =  DB::table("_viddsestatus_nov")
                ->select('id', 'servicio_id', 'estatu_id','fecha_movimiento',
                    DB::raw("DATE_PART('day', '$end_date_e' - fecha_movimiento) AS dias")
                )
                ->where('fecha_ingreso','>=', $start_date_e)
                ->where('fecha_ingreso','<=', $end_date_e)
                ->where('servicio_id', $value)
                ->whereNotIn('ciudadano_id', [508833, 519442, 513061])
                ->whereNotIn('origen_id', [20])
                ->whereIn('ue_id', [16,18,19])
                ->get();

            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['PROM_PEN'] =(int) number_format($arr->avg('dias'),0,'.',',');
                $servicio['DIAS_PEN'] = $arr->count('id');
                $this->vectorServicios[$key] = $servicio;
            }
        }
        return $this->vectorServicios;

    }
    public function getAtendidasPromCiudadano(){

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

        // dias
        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr = DB::table("_viddsestatus_nov")
                ->select('id', 'servicio_id', 'estatu_id', 'fecha_movimiento',
                    DB::raw("DATE_PART('day', '$end_date_e' - fecha_movimiento) AS dias")
                )
                ->where('fecha_ingreso','>=', $this->fecha_desde)
                ->whereBetween('fecha_movimiento',[$start_date_e, $end_date_e])
                ->where('servicio_id', $value)
                ->whereNotIn('ciudadano_id', [508833, 519442, 513061])
                ->whereNotIn('origen_id', [20])
                ->whereIn('estatu_id', [17, 20, 21, 22])
                ->get();

            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['DIAS_ATE'] = $arr->count('id');
                $this->vectorServicios[$key] = $servicio;
            }

        }

        return $this->vectorServicios;

    }

    public function getPendientesPromDelegados(){

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

//        _vimov_filter_sm
        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr =  DB::table("_videpdenservestatus")
                ->select('id', 'servicio_id', 'estatu_id','fecha_movimiento',
                    DB::raw("DATE_PART('day', '$end_date_e' - fecha_movimiento) AS dias")
                )
                ->where('fecha_ingreso','>=', $start_date_e)
                ->where('fecha_ingreso','<=', $end_date_e)
                ->where('servicio_id', $value)
                ->where('origen_id',20)
                ->whereIn('ue_id', [16, 18, 19])
                ->get();

            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['DIAS_PEN_DEL'] = $arr->count('id');
                $this->vectorServicios[$key] = $servicio;
            }
        }
        return $this->vectorServicios;

    }
    public function getAtendidasPromDelegados(){

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

        // dias
        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr = DB::table("_videpdenservestatus")
                ->select('id', 'servicio_id', 'estatu_id', 'fecha_movimiento',
                    DB::raw("DATE_PART('day', '$end_date_e' - fecha_movimiento) AS dias")
                )
                ->where('fecha_ingreso','>=', $this->fecha_desde)
                ->whereBetween('fecha_movimiento',[$start_date_e, $end_date_e])
                ->where('servicio_id', $value)
                ->where('origen_id',20)
                ->whereIn('estatu_id', [17, 20, 21, 22])
                ->get();

            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['DIAS_ATE_DEL'] = $arr->count('id');
                $this->vectorServicios[$key] = $servicio;
            }

        }

        return $this->vectorServicios;

    }

    public function getPendientesPromInstitucion(){

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

//        _vimov_filter_sm

        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr =  DB::table("_videpdenservestatus")
                ->select('id', 'servicio_id', 'estatu_id','fecha_movimiento',
                    DB::raw("DATE_PART('day', '$end_date_e' - fecha_movimiento) AS dias")
                )
                ->where('fecha_ingreso','>=', $start_date_e)
                ->where('fecha_ingreso','<=', $end_date_e)
                ->where('servicio_id', $value)
                ->whereIn('ciudadano_id', [508833, 519442, 513061])
                ->whereIn('ue_id', [16, 18, 19])
                ->get();

            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['DIAS_PEN_INS'] = $arr->count('id');
                $this->vectorServicios[$key] = $servicio;
            }
        }
        return $this->vectorServicios;

    }
    public function getAtendidasPromInstitucion(){

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

        // dias
        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr = DB::table("_videpdenservestatus")
                ->select('id', 'servicio_id', 'estatu_id', 'fecha_movimiento',
                    DB::raw("DATE_PART('day', '$end_date_e' - fecha_movimiento) AS dias")
                )
                ->where('fecha_ingreso','>=', $this->fecha_desde)
                ->whereBetween('fecha_movimiento',[$start_date_e, $end_date_e])
                ->where('servicio_id', $value)
                ->whereIn('ciudadano_id', [508833, 519442, 513061])
                ->whereIn('estatu_id', [17, 20, 21, 22])
                ->get();

            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['DIAS_ATE_INS'] = $arr->count('id');
                $this->vectorServicios[$key] = $servicio;
            }

        }

        return $this->vectorServicios;

    }

    public function getLlamadas(){

        $start_date_e = $this->start_date;
        $end_date_e = $this->end_date;

        foreach ($this->ServiciosPrincipales as $key => $value) {
            $arr =  DB::table("_vimov_filter_sm")
                ->select('denuncia_id', 'sue_id', 'ue_id','fecha_ultimo_estatus',
                    DB::raw("DATE_PART('day', '$end_date_e' - fecha_ultimo_estatus) AS dias")
                )
                ->where('fecha_ingreso','>=', $this->fecha_desde)
                ->whereBetween('fecha_ultimo_estatus',[$start_date_e, $end_date_e])
                ->where('sue_id', $value)
                ->whereIn('ue_id', [18,21,22])
                ->get();

//            dd($arr);
//
            if (!$arr->isEmpty()) {
                $servicio = $this->vectorServicios[$key];
                $servicio['LLAMADAS'] = $arr->count('denuncia_id');
                $this->vectorServicios[$key] = $servicio;
            }

        }

        return $this->vectorServicios;

    }


}
