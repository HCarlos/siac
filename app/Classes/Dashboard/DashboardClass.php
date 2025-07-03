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

    protected $vectorServicios;
    protected $ServiciosPrincipales;
    protected $ArrSolicitudesIRLabel;
    protected $ArrSolicitudesIRValue;
    protected $arrCoorDR;


    public function __construct(){
        // Inicializar como colección
        $this->vectorServicios = collect([
            ['sue_id' => 483, 'Servicio' => 'BACHEO', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0],
            ['sue_id' => 508, 'Servicio' => 'DESAZOLVE DE DRENAJE', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0],
            ['sue_id' => 476, 'Servicio' => 'FUGA DE AGUA', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0],
            ['sue_id' => 503, 'Servicio' => 'RECOLECCIÓN DE RESIDUOS SÓLIDOS', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0],
            ['sue_id' => 479, 'Servicio' => 'ALCANTARILLA', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0],
            ['sue_id' => 466, 'Servicio' => 'LUMINARIAS', 'CR' => 0, 'DR' => 0, 'IR' => 0, 'TR' => 0, 'CA' => 0, 'DA' => 0, 'IA' => 0, 'TA' => 0],
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

//        dd($this->arrCoorDR);

        $geo =  DB::table("_viddss")
            ->select('sue_id','ue_id','ciudadano_id','fecha_ultimo_estatus')
            ->whereIn('sue_id', $this->ServiciosPrincipales)
            ->where('ambito_dependencia', 2)
            ->whereBetween('fecha_ingreso',[$end_date." 00:00:00",$end_date." 23:59:59"])
            ->get();

        foreach($geo as $g){
            $this->setAsigndata($g->sue_id,$g->ciudadano_id,$g->ue_id,$end_date,$g->fecha_ultimo_estatus);
        }
        return $this->vectorServicios;
    }

    private function setAsigndata($sue_id, $ciudadano_id, $ue_id, $end_date,$fecha_ultimo_estatus){

        $fecha_ultimo_estatus = Carbon::parse($fecha_ultimo_estatus)->format('Y-m-d');

        // Encontrar el índice usando el método search
        $index = $this->vectorServicios->search(function ($item) use ($sue_id) {
            return $item['sue_id'] == $sue_id;
        });

        if ($index === false) return false;

        // Obtener referencia mutable al servicio
        $servicio = $this->vectorServicios[$index];

        if ($ue_id === 17 && $end_date === $fecha_ultimo_estatus) {
            if ($this->ArrSolicitudesIRValue->contains($ciudadano_id)) {
                $servicio['IA']++;
            } elseif ($this->arrCoorDR->contains($ciudadano_id)) {
                $servicio['DA']++;
            } else {
                $servicio['CA']++;
            }
            $servicio['TA']++;
        } else {
            if ($this->ArrSolicitudesIRValue->contains($ciudadano_id)) {
                $servicio['IR']++;
            } elseif ($this->arrCoorDR->contains($ciudadano_id)) {
                $servicio['DR']++;
            } else {
                $servicio['CR']++;
            }
            $servicio['TR']++;
        }

        // Actualizar directamente en la colección
        $this->vectorServicios[$index] = $servicio;

        return true;
    }


}
