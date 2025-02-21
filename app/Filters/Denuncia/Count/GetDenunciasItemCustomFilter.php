<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Filters\Denuncia\Count;

use App\Filters\Common\QueryFilter;
use App\Http\Controllers\Funciones\FuncionesController;
use Illuminate\Support\Facades\Auth;

class GetDenunciasItemCustomFilter extends QueryFilter{


    public function rules(): array{
        return [
            'filterdata'      => '',
        ];
    }

    //filterdata


    public function filterdata($query, $search){
        $search = isset($search['search']) ? $search['search'] : '';
        $search = strtoupper($search);

        $IsEnlace =Auth::user()->isRole('ENLACE');
        $IsAdminArchivo =Auth::user()->isRole('USER_ARCHIVO_ADMIN');
        $DependenciaArray = '';
        $DependenciaIdArray = [];
        IF ($IsEnlace) {
            $DependenciaIdArray = Auth::user()->DependenciaIdArray;
            $filters['dependencia_id'] = $DependenciaIdArray;
            $filters['search'] = $search;
        }elseif ($IsAdminArchivo){
                $filters['cerrado'] = 'true';
//        }elseif ($IsEnlace && Auth::user()->isRole('USER_SAS_CAP|USER_SAS_ADMIN') && !Auth::user()->isRole('Administrator|SysOp') ){
//            $filters['search'] = $search;
        }elseif ( Auth::user()->isRole('CIUDADANO|DELEGADO') && !Auth::user()->isRole('Administrator|SysOp') ){
            $filters['ciudadano_id'] = Auth::user()->id;
            //dd("2");
        }else{
            //dd("3");
            $filters['search'] = $search;
            //dd("3");
        }


        $filters['status_denuncia'] = '1';
        $filters['ambito_dependencia'] = '99';
//        $filters['ambito_dependencia'] = FuncionesController::arrAmbitosViejitos();
        session(['IsEnlace' => $IsEnlace]);
        session(['IsAdminArchivo' => $IsAdminArchivo]);
        session(['DependenciaArray' => $DependenciaArray]);
        session(['DependenciaIdArray' => $DependenciaIdArray]);

//        dd( $filters );

        return $query->filterBy($filters);

    }

    public function validIsEnlace(){

    }


}
