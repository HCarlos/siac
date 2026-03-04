<?php
/*
 * Copyright (c) 2026. Realizado por Carlos Hidalgo
 */

namespace App\Classes\Denuncia;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ParaReportesClass{

    public static function GetFiltroPorFechaYServicios($start_date_e, $end_date_e, $ServiciosPrincipales): array{

//        $arrays = [];

//        $cacheKey = '_vimov_filter_sm' . md5($ServiciosPrincipales[0] . $start_date_e . $end_date_e); // Genera una clave de caché única
//        $data = Cache::remember($cacheKey, 30, function () use ($ServiciosPrincipales, $start_date_e, $end_date_e) {
            return DB::table("_vimov_filter_sm")
                ->whereIn('servicio_id', $ServiciosPrincipales)
                ->where('fecha_ingreso', '>=', $start_date_e)
                ->where('fecha_ingreso', '<=', $end_date_e)
                ->pluck('denuncia_id')
                ->toArray();

//        });
//
//        return $arrays;

    }

    public static function GetFiltroPorFechaYServiciosViDenuncias($start_date_e, $end_date_e, $ServiciosPrincipales): array{

//        $arrays = [];
//
//        $cacheKey = '_videnuncias' . md5($ServiciosPrincipales[0] . $start_date_e . $end_date_e); // Genera una clave de caché única
//        $data = Cache::remember($cacheKey, 30, function () use ($ServiciosPrincipales, $start_date_e, $end_date_e) {

            return DB::table("_videnuncias")
                ->where('ambito_dependencia', 2)
                ->whereIn('servicio_id', $ServiciosPrincipales)
                ->where('fecha_ingreso', '>=', $start_date_e)
                ->where('fecha_ingreso', '<=', $end_date_e)
                ->pluck('id')
                ->toArray();

//        });
//
//        return $arrays;

    }




}
