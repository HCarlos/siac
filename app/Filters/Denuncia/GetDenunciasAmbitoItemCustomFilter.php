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
        }elseif ( Auth::user()->isRole('CIUDADANO|DELEGADO') && !Auth::user()->isRole('Administrator|SysOp') ){
            $filters['ciudadano_id'] = Auth::user()->id;
        }elseif ( Auth::user()->isRole('DELEGADOS') ){
            $filters['creadopor_id'] = Auth::user()->id;
        }elseif ( Auth::user()->isRole('DELEGADOS') ){
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

        $filters['status_denuncia'] = '1';
        $filters['ambito_dependencia'] = session::get('ambito_dependencia');
        $filters['ambito_estatus'] = session::get('ambito_estatus');

//        dd( $filters );

        return $query->ambitoFilterBy($filters);

    }

    public function validIsEnlace(){

    }


}
