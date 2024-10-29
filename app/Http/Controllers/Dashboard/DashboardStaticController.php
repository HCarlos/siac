<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\_viServicios;
use App\Models\Denuncias\Denuncia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardStaticController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    protected function index(Request $request){

        $data = $request->all();

        $arrPorStatus = [
            ["atendidas" => 0, "porcentaje" => 0],
            ["en_proceso" => 0, "porcentaje" => 0],
            ["pendientes" => 0, "porcentaje" => 0],
        ];

        // atendidas = 3, 4, 6, 12, 13
        // en_proceso = 1, 2, 5, 7, 9, 10, 11
        // pendientes = 8

//        dd($data);


        ini_set('max_execution_time', 300);
        $f = new FuncionesController();

        if (isset($data['fecha_inicial'])) {
            $inicioMes = $data['fecha_inicial'];
        } else {
            $inicioMes = Carbon::now()->startOfMonth();
            $inicioMes =  $inicioMes->format('Y-m-d');
        }
//        $inicioMes = $inicioMes.' 00:00:00';

        if (isset($data['fecha_final'])) {
            $finMes = $data['fecha_final'];
        } else {
            $finMes = Carbon::now()->endOfMonth();
            $finMes =  $finMes->format('Y-m-d');
        }
//        $finMes = $finMes.' 23:59:59';

        if (isset($data['servicio_id'])) {
            $servicio_id = $data['servicio_id'];
        } else {
            $servicio_id = 0;
        }


        $fechaInicioAño = Carbon::now()->startOfYear();
        $fechaFinAño = Carbon::now()->endOfYear();

        $srvOp = _viDDSs::query()
            ->select('dependencia_id')
            ->whereIn('dependencia_id',[1,13])
            ->whereBetween('fecha_ingreso',[$inicioMes,$finMes])
            ->where('is_visible_nombre_corto_ss',true)
            ->count();
        $sumItem = 0;
//        dd($srvOp);
//        foreach ($srvOp as $d) {
//            $sumItem += $d->count();
//        }
//        $srvOp = $sumItem;


//        dd($inicioMes);
//        dd($finMes);

        $srvSAS = _viDDSs::query()
            ->select('dependencia_id')
            ->where('dependencia_id',12)
            ->whereBetween('fecha_ingreso',[$inicioMes,$finMes])
            ->where('is_visible_nombre_corto_ss',true)
            ->count();

        $srvLimpia = _viDDSs::query()
            ->select('dependencia_id')
            ->where('dependencia_id',2)
            ->whereBetween('fecha_ingreso',[$inicioMes,$finMes])
            ->where('is_visible_nombre_corto_ss',true)
            ->count();

        $Servicios = _viServicios::query()->select('id','servicio','nombre_corto_ss','abreviatura_dependencia')
            ->where('ambito_dependencia',2)
            ->where('is_visible_nombre_corto_ss',true)
            ->orderBy('servicio')
            ->get();

//        $srvLimpia = _viDDSs::query()
//            ->select('servicio_id')
//            ->where('dependencia_id',13)
//            ->whereBetween('fecha_ingreso',[$inicioMes,$finMes])
//            ->count();

        // Gráfico de Solicitud por tipo de servicio
        $srv1 = DB::table("_viddss")
            ->select('nombre_corto_ss as name', DB::raw('count(servicio_id) as data'))
            ->where('ambito_dependencia',2)
            ->where('is_visible_nombre_corto_ss',true)
            ->whereBetween('fecha_ingreso',[$inicioMes,$finMes])
            ->groupBy('nombre_corto_ss')
            ->get();

//        dd($srv1);

//        dd($finMes);
        // Grááfico de Estatus de solicitudes atendidas
        $srv2 = DB::table("_viddss")
            ->select("ultimo_estatus_resuelto as name", DB::raw("count(estatus_id) as data"))
            ->where("ambito_dependencia",2)
            ->whereBetween("fecha_ingreso", [$inicioMes,$finMes])
            ->groupBy("ultimo_estatus_resuelto")
            ->get();



//        dd($srv2);

        $totalRes = $srv2[0]->data + $srv2[1]->data;
        $porcentajeAtendidos = number_format((($srv2[1]->data/$totalRes) * 100), 0, '.',',');

        // Grááfico de Estatus de solicitudes Por servicio
        $selServ = "";
        if ($servicio_id > 0) {
            $arrIntoServicios = array($servicio_id);
            $srv0 = Servicio::find($servicio_id);
            $selServ = $srv0->nombre_corto_ss;
        }else{
            $arrIntoServicios = [];
            foreach ($Servicios as $d) {
                $arrIntoServicios[] = $d->id;
            }
            $selServ = "Todos los servicios";
        }
        $srv3 = DB::table("_viddss")
            ->select('estatus_id','estatus as name', DB::raw('count(estatus_id) as data'))
            ->whereBetween('fecha_ingreso',[$inicioMes,$finMes])
            ->where("ambito_dependencia",2)
            ->whereIn('servicio_id',$arrIntoServicios)
            ->where('is_visible_nombre_corto_ss',true)
            ->groupBy('estatus_id','estatus')
            ->get();

//        dd($srv3);
        $totalReg = 0;
        foreach ($srv3 as $d) {
            switch ($d->estatus_id) {
                case 3:
                case 4:
                case 6:
                case 12:
                case 13:
                    $arrPorStatus[0]["atendidas"] += $d->data;
                    break;
                case 1:
                case 2:
                case 5:
                case 7:
                case 9:
                case 10:
                case 11:
                    $arrPorStatus[1]["en_proceso"] += $d->data;
                    break;
                case 8:
                    $arrPorStatus[2]["pendientes"] += $d->data;
                    break;
            }
            $totalReg += $d->data;
        }

//        $inicioMes = $f->fechaEspanol($inicioMes);
//        $finMes    = $f->fechaEspanol($finMes);

        $arrPorStatus[0]["porcentaje"] = $arrPorStatus[0]["atendidas"] > 0 ? number_format(($arrPorStatus[0]["atendidas"] / $totalReg) * 100, 0, '.',',') : 0;
        $arrPorStatus[1]["porcentaje"] = $arrPorStatus[1]["en_proceso"] > 0 ? number_format(($arrPorStatus[1]["en_proceso"] / $totalReg) * 100, 0, '.',',') : 0;
        $arrPorStatus[2]["porcentaje"] = $arrPorStatus[2]["pendientes"] > 0 ? number_format(($arrPorStatus[2]["pendientes"] / $totalReg) * 100, 0, '.',',') : 0;


//        ->where('fecha_limite','>=',now()->format('Y-m-d'))

        $srv4 = DB::table("_viddss")
            ->select('*')
            ->whereBetween('fecha_ingreso',[$inicioMes,$finMes])
            ->where('fecha_ejecucion','<=',now()->format('Y-m-d'))
            ->where("ambito_dependencia",2)
            ->where('is_visible_nombre_corto_ss',true)
            ->where('estatus_id',8)
            ->orderBy('fecha_ejecucion')
            ->get();

//        dd($srv4);

        return view('dashboard.static.dashboard_static',
            [
                'srvOP'   => number_format($srvOp, 0, '.',','),
                'srvSAS'    => number_format($srvSAS, 0, '.',','),
                'srvLimpia' => number_format($srvLimpia, 0, '.',','),
                'srvTotal' => number_format($srvOp + $srvSAS + $srvLimpia, 0, '.',','),
                'servicios' => $Servicios,
                'selServ' => $selServ,
                'arrSrv1' => $srv1,
                'arrSrv4' => $srv4,
                'atendidas' => $porcentajeAtendidos,
                'arrPorStatus' => $arrPorStatus,
                'rango_de_consulta' => $f->fechaEspanol($inicioMes).' - '.$f->fechaEspanol($finMes),
                'inicio_mes' => $inicioMes,
                'fin_mes' => $finMes,
            ]);

    }







}
