<?php
/*
 * Copyright (c) 2021. Realizado por Carlos Hidalgo
 */

namespace App\Filters\Denuncia;

use App\Filters\Common\QueryFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GetDenunciasAmbitoItemCustomFilter extends QueryFilter{


    public function rules(): array{
        return [
            'filterdata'         => '',
        ];
    }

    public function filterdata($query, $search){
        $search = isset($search['search']) ? $search['search'] : '';
        $search = strtoupper($search);

//        dd(" SI");

        $IsEnlace               = Auth::user()->isRole('ENLACE') ?? false;
//        dd("$IsEnlace");
        $IsAdminArchivo         = Auth::user()->isRole('USER_ARCHIVO_ADMIN');
        $IsDelegados            = Auth::user()->isRole('DELEGADOS');
        $IsCoordinadorDelegados = Auth::user()->isRole('COORDINACION_DE_DELEGADOS');
        $DelegadosIdArray = [];
        $DependenciaArray = '';
        $DependenciaIdArray = [];
        $ServicioIdArray = [];
        $filters['search'] = $search;


        if ($IsEnlace) {
            $ServicioIdArray = Auth::user()->ServicioIdArray;
            if (count($ServicioIdArray) > 0){
                $filters['servicio_id'] = $ServicioIdArray;
            }else{
                $DependenciaIdArray = Auth::user()->DependenciaIdArray;
                $filters['dependencia_id'] = $DependenciaIdArray;
            }
        }elseif ($IsAdminArchivo){
                $filters['cerrado'] = 'true';
        }elseif ( Auth::user()->isRole('CIUDADANO|DELEGADO') && !Auth::user()->isRole('Administrator|SysOp|test_admin') ){
            $filters['ciudadano_id'] = Auth::user()->id;
        }elseif ( $IsDelegados ){
            $filters['creadopor_id'] = Auth::user()->id;
        }elseif ( $IsCoordinadorDelegados ){
            $DelegadosIdArray = Auth::user()->DelegadosIdArray;
            $filters['creadopor_id'] = $DelegadosIdArray;
        }else{
            $filters['search'] = $search;
            //dd("3");
        }
        session(['IsEnlace' => $IsEnlace]);
        session(['IsAdminArchivo' => $IsAdminArchivo]);
        session(['DependenciaArray' => $DependenciaArray]);
        session(['DependenciaIdArray' => $DependenciaIdArray]);
        session(['ServicioIdArray' => $ServicioIdArray]);
        session(['DelegadosIdArray' => $DelegadosIdArray]);

        $filters['status_denuncia'] = '1';
        $filters['ambito_dependencia'] = Session::get('ambito_dependencia');
        $filters['ambito_estatus'] = Session::get('ambito_estatus');

//        dd( $filters );


        return $query->ambitoFilterBy($filters);

    }

    public function validIsEnlace(){

    }


}
