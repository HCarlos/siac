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
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardStaticThreeController extends Controller{

    public function __construct(){
        ini_set('max_execution_time', 300);
        $this->middleware('auth');
    }

    protected function index(Request $request){

        $data = $request->all();

        $arrPorStatus = [
            ["atendidas" => 0, "porcentaje" => 0],
            ["en_proceso" => 0, "porcentaje" => 0],
            ["pendientes" => 0, "porcentaje" => 0],
        ];

        $arrEstatus = [
            (object)["ue_id" => 16, "name"=> "RECIBIDA", "data"=> 0],
            (object)["ue_id" => 19, "name"=> "EN PROCESO / PROGRAMADA", "data"=> 0],
            (object)["ue_id" => 17, "name"=> "ATENDIDA", "data"=> 0],
            (object)["ue_id" => 20, "name"=> "RECHAZADA", "data"=> 0],
            (object)["ue_id" => 18, "name"=> "OBSERVADA", "data"=> 0],
            (object)["ue_id" => 21, "name"=> "CERRADO", "data"=> 0],
        ];

        $f = new FuncionesController();

        if (isset($data['start_date'])) {
            $start_date = $data['start_date'];
        } else {
            $start_date = Carbon::now()->startOfMonth();
            $start_date = $start_date->format('Y-m-d');
        }

        $start_date = DateTime::createFromFormat('m-d-Y', '01-12-2024')->format('Y-m-d');

//                $start_date = $start_date.' 00:00:00';

        if (isset($data['end_date'])) {
            $end_date = $data['end_date'];
        } else {
            $end_date = Carbon::now()->endOfMonth();
            $end_date =  $end_date->format('Y-m-d');
        }
//        $end_date = $end_date.' 23:59:59';

        if (isset($data['servicio_id'])) {
            $servicio_id = $data['servicio_id'];
        } else {
            $servicio_id = 0;
        }


        $start_year = Carbon::now()->startOfYear();
        $end_year = Carbon::now()->endOfYear();

        $srvOp = _viDDSs::query()
            ->select('dependencia_id')
            ->whereIn('dependencia_id',[48,49])
            ->whereBetween('fecha_ingreso',[$start_date,$end_date])
            ->where('is_visible_nombre_corto_ss',true)
            ->count();

        $srvSAS = _viDDSs::query()
            ->select('dependencia_id')
            ->where('dependencia_id',47)
            ->whereBetween('fecha_ingreso',[$start_date,$end_date])
            ->where('is_visible_nombre_corto_ss',true)
            ->count();

        $srvLimpia = _viDDSs::query()
            ->select('dependencia_id')
            ->where('dependencia_id',50)
            ->whereBetween('fecha_ingreso',[$start_date,$end_date])
            ->where('is_visible_nombre_corto_ss',true)
            ->count();

        $Servicios = _viServicios::query()->select('id','servicio','nombre_corto_ss','abreviatura_dependencia')
            ->where('ambito_dependencia',2)
            ->where('is_visible_nombre_corto_ss',true)
            ->orderBy('servicio')
            ->get();


        // Grááfico de Estatus de solicitudes Por servicio
        $selServ = "";
        if ($servicio_id > 0) {
            $arrIntoServicios = array($servicio_id);
            $srv0 = Servicio::find($servicio_id);
            $selServ = $srv0->nombre_corto_ss;
//            $selServ = $srv0->servicio;
        }else{
            $arrIntoServicios = [];
            foreach ($Servicios as $d) {
                $arrIntoServicios[] = $d->id;
            }
            $selServ = "Todos los servicios";
        }
        $srv3 = DB::table("_viddss")
            ->select('estatus_id','estatus as name', DB::raw('count(estatus_id) as data'))
            ->whereBetween('fecha_ingreso',[$start_date,$end_date])
            ->where("ambito_dependencia",2)
            ->whereIn('servicio_id',$arrIntoServicios)
            ->where('is_visible_nombre_corto_ss',true)
            ->groupBy('estatus_id','estatus')
            ->get();

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

//        $start_date = $f->fechaEspanol($start_date);
//        $end_date    = $f->fechaEspanol($end_date);

        $arrPorStatus[0]["porcentaje"] = $arrPorStatus[0]["atendidas"] > 0 ? number_format(($arrPorStatus[0]["atendidas"] / $totalReg) * 100, 2, '.',',') : 0;
        $arrPorStatus[1]["porcentaje"] = $arrPorStatus[1]["en_proceso"] > 0 ? number_format(($arrPorStatus[1]["en_proceso"] / $totalReg) * 100, 2, '.',',') : 0;
        $arrPorStatus[2]["porcentaje"] = $arrPorStatus[2]["pendientes"] > 0 ? number_format(($arrPorStatus[2]["pendientes"] / $totalReg) * 100, 2, '.',',') : 0;


//        ->where('fecha_limite','>=',now()->format('Y-m-d'))





        // Gráfico de Solicitud por tipo de servicio
        $srv1 = DB::table("_viddss")
            ->select('nombre_corto_ss as name', DB::raw('count(servicio_id) as data'))
            ->where('ambito_dependencia',2)
            ->where('is_visible_nombre_corto_ss',true)
            ->whereBetween('fecha_ingreso',[$start_date,$end_date])
            ->groupBy('nombre_corto_ss')
            ->get();

//        dd($srv1);

//        dd($end_date);
        // Grááfico de Estatus de solicitudes atendidas
        $srv2 = DB::table("_viddss")
            ->select(["ultimo_estatus as name", "ue_id", DB::raw("count(ue_id) as data")])
            ->where("ambito_dependencia",2)
            ->whereBetween('fecha_ingreso',[$start_date,$end_date])
            ->groupBy(["ultimo_estatus","ue_id"])
            ->get();

//        dd($srv2);
        foreach ($arrEstatus as $a) {
            foreach ($srv2 as $d){
                if ($d->ue_id === $a->ue_id) {
                    $a->data = $d->data;
                }
            }
        }

//        dd($arrEstatus);


        $r0 = isset($srv2[0]) ? $srv2[0]->data :0;
        $r1 = isset($srv2[1]) ? $srv2[1]->data : 0;

        $totalRes =  $r0 + $r1;
        //$srv2[0]->data ?? 0 + $srv2[1]->data ?? 0;
        $porcentajeAtendidos = 0;
        if ($r1 > 0) {
            $porcentajeAtendidos = number_format((($r1/$totalRes) * 100), 2, '.',',');
        }

        // Tabla de Servicios Vencidos
        $srv4 = DB::table("_viddss")
            ->select('*')
            ->whereBetween('fecha_ingreso',[$start_date,$end_date])
            ->where('fecha_ejecucion','<=',now()->format('Y-m-d'))
            ->where("ambito_dependencia",2)
            ->where('is_visible_nombre_corto_ss',true)
            ->where('estatus_id',8)
            ->whereIn('servicio_id',$arrIntoServicios)
            ->orderBy('fecha_ejecucion')
            ->get();

//        dd($srv4);

        // Tabla de Servicios Urgentes
        $srv5 = DB::table("_viddss")
            ->select('*')
            ->whereBetween('fecha_ingreso',[$start_date,$end_date])
            ->where("ambito_dependencia",2)
            ->where('is_visible_nombre_corto_ss',true)
            ->where('prioridad_id',1)
            ->where("ultimo_estatus_resuelto",0)
            ->whereIn('servicio_id',$arrIntoServicios)
            ->orderBy('fecha_ingreso')
            ->get();

//        dd($srv5);

        // Tabla de Servicios Prioritarios
        $srv6 = DB::table("_viddss")
            ->select('*')
            ->whereBetween('fecha_ingreso',[$start_date,$end_date])
            ->where("ambito_dependencia",2)
            ->where('is_visible_nombre_corto_ss',true)
            ->whereIn('prioridad_id',[1,3])
            ->where("ultimo_estatus_resuelto",0)
            ->whereIn('servicio_id',$arrIntoServicios)
            ->orderBy('fecha_ingreso')
            ->get();

//        dd($srv6);

        return view('dashboard.static.dashboard_static_three',
            [
                'srvOP'   => number_format($srvOp, 0, '.',','),
                'srvSAS'    => number_format($srvSAS, 0, '.',','),
                'srvLimpia' => number_format($srvLimpia, 0, '.',','),
                'srvTotal' => number_format($srvOp + $srvSAS + $srvLimpia, 0, '.',','),
                'servicios' => $Servicios,
                'selServ' => $selServ,
                'arrSrv1' => $srv1,
                'arrSrv4' => $srv4,
                'arrSrv5' => $srv5,
                'arrSrv6' => $srv6,
                'atendidas' => $porcentajeAtendidos,
                'arrPorStatus' => $arrPorStatus,
                'rango_de_consulta' => $f->fechaEspanol($start_date).' - '.$f->fechaEspanol($end_date),
                'inicio_mes' => $start_date,
                'fin_mes' => $end_date,
            ]);

    }







}
