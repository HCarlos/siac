<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Classes\Dashboard;

use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\lessThanOrEqual;

class DashboardClass{

    public $vectorServicios;
    protected $ServiciosPrincipales;
    protected $ArrSolicitudesIRLabel;
    protected $ArrSolicitudesIRValue;
    protected $arrCoorDR;


    public function __construct(){
        // Inicializar como colección
        $this->vectorServicios = collect([
            ['sue_id' => 483, 'Servicio' => 'BACHEO', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => []],
            ['sue_id' => 508, 'Servicio' => 'DESAZOLVE DE DRENAJE', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => []],
            ['sue_id' => 476, 'Servicio' => 'FUGA DE AGUA', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => []],
            ['sue_id' => 503, 'Servicio' => 'RECOLECCIÓN DE RESIDUOS SÓLIDOS', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => []],
            ['sue_id' => 479, 'Servicio' => 'ALCANTARILLA', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => []],
            ['sue_id' => 466, 'Servicio' => 'LUMINARIAS', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0 ,'DIAS_ATRAS' => []],
        ]);

        $this->ServiciosPrincipales = [483, 508, 476, 503, 479, 466];

        // Asegurar que estas propiedades sean colecciones
        $this->ArrSolicitudesIRValue = collect([508833, 519442]); // Inicializar con tus valores reales
        $this->ArrSolicitudesIRLabel = collect(["SAS", "LIMPIA"]);
        $this->arrCoorDR             = collect([]); // Inicializar con tus valores reales

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
            if ($this->ArrSolicitudesIRValue->contains($ciudadano_id)) {
                $servicio['IA']++;
            } elseif ($this->arrCoorDR->contains($creadopor_id)) {
                $servicio['DA']++;
            } else {
                $servicio['CA']++;
            }
            $servicio['TA']++;
        }
        if ($ue_id !== 17 && $fecha_ingreso === $fecha_ultimo_estatus) {
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
            if ($g->fecha_ingreso === $g->fecha_ultimo_estatus) {
                switch ($g->ue_id) {
                    case 6:
                    case 17:
                        $atendidas++;
                        break;
                    case 20:
                        $rechazadas++;
                        break;
                    case 16:
                    case 19:
                        $pendientes++;
                        break;
                }
            }
//            $sue_id = $g->sue_id;
        }
        return ["fecha" => Carbon::parse($start_date)->format('Y-m-d'), "atendidas" => $atendidas, "rechazadas" => $rechazadas, "pendientes" => $pendientes];
    }



}
