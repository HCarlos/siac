<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\Dashboard;

use App\Classes\Denuncia\ActualizaEstadisticasARO;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\CentroLocalidad;
use App\Models\Denuncias\_viDepDenServEstatus;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SMReportesController extends Controller{

    public function __construct(){
        ini_set('max_execution_time', 300);
        $this->middleware('auth');
    }

    protected function index(Request $request){

        $data = $request->all();

//        dd($data);

        $f = new FuncionesController();

        if ($data === []){
            $start_date = Carbon::now();
            $start_date = $start_date->format('Y-m-d');
            $end_date = $start_date;
            $filter = 'hoy';
        }else{
            if (isset($data['filter'])){
                switch ($data['filter']) {
                    case 'hoy':
                        $start_date = Carbon::now();
                        $start_date = $start_date->format('Y-m-d');
                        $end_date = $start_date;
                        break;
                    case 'mes':
                        $start_date = Carbon::now()->startOfMonth();
                        $start_date = $start_date->format('Y-m-d');
                        $end_date = Carbon::now()->endOfMonth();
                        $end_date =  $end_date->format('Y-m-d');
                        break;
                    case 'anio':
                        $start_date = Carbon::now()->startOfYear();
                        $start_date = $start_date->format('Y-m-d');
                        $end_date = Carbon::now()->endOfYear();
                        $end_date =  $end_date->format('Y-m-d');
                        break;
                    default:
                        $start_date = $data['start_date'];
                        $end_date = $data['end_date'];
                        break;
                }
                $filter = $data['filter'];
            }else{
                $start_date = Carbon::now();
                $start_date = $start_date->format('Y-m-d');
                $end_date = $start_date;
                $filter = 'hoy';
            }

        }

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['filter'] = $filter;

        $file_out = "file_servicios_principales_".$start_date.'_'.$end_date.'.json';
        $isExistFile = false; //Storage::disk('public')->exists($file_out);


        $f = new FuncionesController();

        $menu = $f->menuDashBoard(7);

        return view('dashboard.static.dashboard_sm_reportes',
            [
                'filter' => '',
                'start_date' => $start_date,
                'end_date' => $end_date,
                'file_out' => $file_out,
                'menu' => $menu,
            ]);

    }


    // INICIA EL MODULO DE FUNCIONES AUXILIARES

    static function getUltimoEstatus($start_date,$end_date,$ServiciosPrincipales){
//        ->where("ambito_dependencia",2)
//        return DB::table("_viddss")
//            ->select(["ultimo_estatus as name", "ue_id", DB::raw("count(ue_id) as data")])
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->whereIn('sue_id', [483,508,476,503,479,466,567,568])
//            ->groupBy(["ultimo_estatus","ue_id"])
//            ->get();


        return DB::table("_vimov_filter_sm")
            ->select(["estatus as name", "estatu_id as ue_id", DB::raw("count(estatu_id) as data")])
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->whereIn('servicio_id', [483,508,476,503,479,466,567,568])
            ->groupBy(["estatus","estatu_id"])
            ->get();


    }

    static function getEstatusDependencia($start_date,$end_date,$dependencia_id,$ue_id,$ServiciosPrincipales){

//        return DB::table("_viddss")
//            ->select('abreviatura as label', DB::raw('count(dependencia_id) as data'))
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->where('ambito_dependencia',2)
//            ->where('dependencia_id',$dependencia_id)
//            ->whereIn('sue_id', $ServiciosPrincipales)
//            ->where('ue_id',$ue_id)
//            ->groupBy('abreviatura')
//            ->first();

        return DB::table("_vimov_filter_sm")
            ->select('abreviatura as label', DB::raw('count(dependencia_id) as data'))
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->where('dependencia_id',$dependencia_id)
            ->whereIn('servicio_id', $ServiciosPrincipales)
            ->where('estatu_id',$ue_id)
            ->groupBy('abreviatura')
            ->first();
    }
    static function getEstatus($start_date,$end_date,$dependencia_id,$ServiciosPrincipales){

//        return DB::table("_viddss")
//            ->select('dependencia_id as label', DB::raw('count(dependencia_id) as total'))
//            ->where('ambito_dependencia',2)
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->where('dependencia_id',$dependencia_id)
//            ->whereIn('sue_id', $ServiciosPrincipales)
//            ->groupBy('dependencia_id')
//            ->first();

        return DB::table("_vimov_filter_sm")
            ->select('dependencia_id as label', DB::raw('count(dependencia_id) as total'))
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->where('dependencia_id',$dependencia_id)
            ->whereIn('servicio_id', $ServiciosPrincipales)
            ->groupBy('dependencia_id')
            ->first();

    }
    static function getEstatusUE($start_date,$end_date,$dependencia_id,$ue_id,$ServiciosPrincipales){

//        return DB::table("_viddss")
//            ->select('dependencia_id as label', DB::raw('count(dependencia_id) as total'))
//            ->where('ambito_dependencia',2)
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->where('dependencia_id',$dependencia_id)
//            ->whereIn('sue_id', $ServiciosPrincipales)
//            ->where('ue_id',$ue_id)
//            ->groupBy('dependencia_id')
//            ->first();

        return DB::table("_vimov_filter_sm")
            ->select('dependencia_id as label', DB::raw('count(dependencia_id) as total'))
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->where('dependencia_id',$dependencia_id)
            ->whereIn('servicio_id', $ServiciosPrincipales)
            ->where('estatu_id',$ue_id)
            ->groupBy('dependencia_id')
            ->first();

    }

    static function getServiciosDependencia($start_date,$end_date,$sue_id){

//        return DB::table("_viddss")
//            ->select('abreviatura as label', DB::raw('count(sue_id) as total'))
//            ->where('ambito_dependencia',2)
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->where('sue_id',$sue_id)
//            ->groupBy('abreviatura')
//            ->first();

        return DB::table("_vimov_filter_sm")
            ->select('abreviatura as label', DB::raw('count(servicio_id) as total'))
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->where('servicio_id',$sue_id)
            ->groupBy('abreviatura')
            ->first();


    }

    static function getAtiempoVsDestiempo($start_date,$end_date,$unidad_id,$ue_id,$ServiciosPrincipales){

//        return DB::table("_viddss")
//            ->select(
//                DB::raw("SUM(CASE WHEN fecha_dias_ejecucion >= CURRENT_DATE THEN 1 ELSE 0 END) AS atiempo"),
//                DB::raw("SUM(CASE WHEN CURRENT_DATE > fecha_dias_ejecucion THEN 1 ELSE 0 END) AS conrezago")
//            )
//            ->where('ambito_dependencia', 2)
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->where('dependencia_id', $unidad_id)
//            ->whereIn('sue_id', $ServiciosPrincipales)
//            ->where('ue_id', $ue_id)
//            ->groupBy('ue_id')
//            ->first();

        return DB::table("_vimov_filter_sm")
            ->select(
                DB::raw("SUM(CASE WHEN fecha_dias_ejecucion >= CURRENT_DATE THEN 1 ELSE 0 END) AS atiempo"),
                DB::raw("SUM(CASE WHEN CURRENT_DATE > fecha_dias_ejecucion THEN 1 ELSE 0 END) AS conrezago")
            )
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->where('dependencia_id', $unidad_id)
            ->whereIn('servicio_id', $ServiciosPrincipales)
            ->where('estatu_id', $ue_id)
            ->groupBy('estatu_id')
            ->first();


    }

    static function getGeoDenuncias($start_date,$end_date,$ServiciosPrincipales){

//        $cacheKey = '_viddss_' . md5($ServiciosPrincipales[0] . $start_date . $end_date);
//        $data = Cache::remember($cacheKey, 60, function () use ($ServiciosPrincipales, $start_date, $end_date) {
//            return DB::table("_viddss")
//                ->select(
//                    'id','latitud','longitud','dependencia','abreviatura',
//                    'nombre_corto_ss','ciudadano','fecha_ingreso','fecha_dias_ejecucion',
//                    'fecha_ultimo_estatus', 'fecha_dias_maximos_ejecucion','ultimo_estatus',
//                    'sue_id','servicio_ultimo_estatus','ue_id','dependencia_id','uuid',
//                    'denuncia','centro_localidad_id','ciudadano_id'
//                )
//                ->whereIn('sue_id', $ServiciosPrincipales)
//                ->where('ambito_dependencia', 2)
//                ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
//                ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
//                ->get();
//        });
        //            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])

//        $cacheKey = 'videpdenservestatus_' . md5($ServiciosPrincipales[0] . $start_date . $end_date); // Genera una clave de caché única
//        $data = Cache::remember($cacheKey, 60, function () use ($ServiciosPrincipales, $start_date, $end_date) {
//            return DB::table("_videpdenservestatus")
//                ->where('ambito_dependencia', 2)
//                ->whereIn('servicio_id', $ServiciosPrincipales)
//                ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
//                ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
//                ->get();
//        });

        $cacheKey = '_vimov_filter_sm' . md5($ServiciosPrincipales[0] . $start_date . $end_date); // Genera una clave de caché única
        $data = Cache::remember($cacheKey, 60, function () use ($ServiciosPrincipales, $start_date, $end_date) {
            return DB::table("_vimov_filter_sm")
                ->select(
                    'id','denuncia_id','descripcion','fecha_dias_ejecucion','fecha_dias_maximos_ejecucion',
                    'fecha_ingreso', 'fecha_ultimo_estatus', 'dependencia_id', 'dependencia', 'abreviatura',
                    'ue_id', 'sue_id', 'nombre_corto_ss', 'ciudadano', 'centro_localidad_id', 'latitud','longitud',
                    'estatus','fecha_ultimo_estatus','fecha_ingreso','fecha_dias_ejecucion', 'fecha_dias_maximos_ejecucion',
                    'uuid', 'servicio_id', 'servicio'
                )
                ->whereIn('servicio_id', $ServiciosPrincipales)
                ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
                ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
                ->get();
        });



        return $data;
    }



}
