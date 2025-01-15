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
use Illuminate\Support\Facades\Storage;

class DashboardStaticThreeController extends Controller{

    public function __construct(){
        ini_set('max_execution_time', 300);
        $this->middleware('auth');
    }

    protected function index(Request $request){

        $data = $request->all();
        $arrJson = [];

        $f = new FuncionesController();

        if (isset($data['start_date'])) {
            $start_date = $data['start_date'];
        } else {
            $start_date = Carbon::now()->startOfMonth();
            $start_date = $start_date->format('Y-m-d');
        }

        $start_date = DateTime::createFromFormat('m-d-Y', '01-12-2024')->format('Y-m-d');

        if (isset($data['end_date'])) {
            $end_date = $data['end_date'];
        } else {
            $end_date = Carbon::now()->endOfMonth();
            $end_date =  $end_date->format('Y-m-d');
        }

        $file_out = "file_".$start_date.'_'.$end_date.'.json';
        $isExistFile = Storage::disk('public')->exists($file_out);

        if ( ! $isExistFile) {


            $arrPorStatus = [
                ["atendidas" => 0, "porcentaje" => 0],
                ["en_proceso" => 0, "porcentaje" => 0],
                ["pendientes" => 0, "porcentaje" => 0],
            ];

            $vectorUnidades = [
                (object)["Unidad" => "ALUMBRADO", "Unidad_Id" => 46,"Total" => 0,"Porcentaje" => 0],
                (object)["Unidad" => "ESPACIOS PÚBLICOS", "Unidad_Id" => 49,"Total" => 0,"Porcentaje" => 0],
                (object)["Unidad" => "LIMPIA", "Unidad_Id" => 50,"Total" => 0,"Porcentaje" => 0],
                (object)["Unidad" => "OBRAS PÚBLICAS", "Unidad_Id" => 48,"Total" => 0,"Porcentaje" => 0],
                (object)["Unidad" => "SAS", "Unidad_Id" => 47,"Total" => 0,"Porcentaje" => 0],
            ];
            $totalServ = 0;
            foreach ($vectorUnidades as $key => $value) {
                $f = static::getEstatus($start_date,$end_date,$value->Unidad_Id);
                if ($f) {
                    if ($f->total > 0) {
                        $vectorUnidades[$key]->Total = $f->total;
                        $totalServ += $f->total;
                    }
                }
            }
            foreach ($vectorUnidades as $key => $value) {
                $total = $vectorUnidades[$key]->Total > 0 ? (($vectorUnidades[$key]->Total / $totalServ) * 100)  : 0;
                $vectorUnidades[$key]->Porcentaje = $total;
            }

    //        dd($vectorUnidades);

            $arrEstatus = [
                (object)["ue_id" => 16, "Estatus"=> "RECIBIDA", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0],
                (object)["ue_id" => 19, "Estatus"=> "EN PROCESO / PROGRAMADA", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0],
                (object)["ue_id" => 17, "Estatus"=> "ATENDIDA", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0],
                (object)["ue_id" => 20, "Estatus"=> "RECHAZADA", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0],
                (object)["ue_id" => 18, "Estatus"=> "OBSERVADA", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0],
                (object)["ue_id" => 21, "Estatus"=> "CERRADO", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0],
            ];


            $srv2 = static::getUltimoEstatus($start_date,$end_date);

            foreach ($arrEstatus as $a) {
                foreach ($srv2 as $d){
                    if ($d->ue_id === $a->ue_id) {
                        $a->Total = $d->data;
                        $arrU = [];
                        foreach ($vectorUnidades as $b) {
                            $f = static::getEstatusDependencia($start_date,$end_date,$b->Unidad_Id,$d->ue_id);
                            if ($f !== null) {
    //                            $b->Unidad = $f->label;
                                $b->Total = $f->data;
                            }
                            $arrU[] = $b;
                        }
                        $a->Unidades = $arrU;
                    }
                }
            }

            $vectorServicios = [
                (object)["sue_id" => 483, "Servicio"=> "BACHEO DE VIALIDADES", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 508, "Servicio"=> "DESAZOLVE DE DRENAJE", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 476, "Servicio"=> "FUGA DE AGUA POTABLE", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 503, "Servicio"=> "RECOLECCIÓN DE RESIDUOS SÓLIDOS", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 476, "Servicio"=> "REPARACIÓN DE ALCANTARILLA", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 466, "Servicio"=> "REPARACIÓN DE LUMINARIAS", "Total"=> 0,"Porcentaje" => 0],
            ];

            $totalServ = 0;
            foreach ($vectorServicios as $key => $value) {
                $f = static::getServiciosDependencia($start_date,$end_date,$value->sue_id);
                if ($f) {
                    if ($f->total > 0) {
                        $vectorServicios[$key]->Total = $f->total;
                        $totalServ += $f->total;
                    }
                }
            }

            foreach ($vectorServicios as $key => $value) {
                $total = $vectorServicios[$key]->Total > 0 ? (($vectorServicios[$key]->Total / $totalServ) * 100)  : 0;
                $vectorServicios[$key]->Porcentaje = $total;
            }

    //        dd($vectorServicios);



            $arrJson = (object)[
                "estatus" => $arrEstatus,
                "unidades" => $vectorUnidades,
                "servicios" => $vectorServicios,
            ];


            $jsonData = json_encode($arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            Storage::disk('public')->put($file_out, $jsonData);
        }

        $f = new FuncionesController();

//        dd( Storage::disk('public')->url($file_out) );

        return view('dashboard.static.dashboard_static_three',
            [
                'rango_de_consulta' => $f->fechaEspanol($start_date).' - '.$f->fechaEspanol($end_date),
                'inicio_mes' => $start_date,
                'fin_mes' => $end_date,
                'file_output' => Storage::disk('public')->url($file_out) ?? null,
            ]);

    }


static function getUltimoEstatus($start_date,$end_date){
    return DB::table("_viddss")
        ->select(["ultimo_estatus as name", "ue_id", DB::raw("count(ue_id) as data")])
        ->where("ambito_dependencia",2)
        ->whereBetween('fecha_ingreso',[$start_date,$end_date])
        ->groupBy(["ultimo_estatus","ue_id"])
        ->get();
}

static function getEstatusDependencia($start_date,$end_date,$dependencia_id,$ue_id){
    return DB::table("_viddss")
        ->select('abreviatura as label', DB::raw('count(dependencia_id) as data'))
        ->where('ambito_dependencia',2)
        ->whereBetween('fecha_ingreso',[$start_date,$end_date])
        ->where('dependencia_id',$dependencia_id)
        ->where('ue_id',$ue_id)
        ->groupBy('abreviatura')
        ->first();
}
static function getEstatus($start_date,$end_date,$dependencia_id){
    return DB::table("_viddss")
        ->select('sue_id as label', DB::raw('count(dependencia_id) as total'))
        ->where('ambito_dependencia',2)
        ->whereBetween('fecha_ingreso',[$start_date,$end_date])
        ->where('dependencia_id',$dependencia_id)
        ->groupBy('sue_id')
        ->first();
}

    static function getServiciosDependencia($start_date,$end_date,$sue_id){
        return DB::table("_viddss")
            ->select('abreviatura as label', DB::raw('count(sue_id) as total'))
            ->where('ambito_dependencia',2)
            ->whereBetween('fecha_ingreso',[$start_date,$end_date])
            ->where('sue_id',$sue_id)
            ->groupBy('abreviatura')
            ->first();
    }



}
