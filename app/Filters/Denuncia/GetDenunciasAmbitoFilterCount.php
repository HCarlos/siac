<?php
/*
 * Copyright (c) 2021. Realizado por Carlos Hidalgo
 */

namespace App\Filters\Denuncia;

use App\Filters\Common\QueryFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GetDenunciasAmbitoFilterCount extends QueryFilter{


    public function rules(): array{
        return [
            'status_denuncia' => '1',
            'filterdata'      => ''
        ];
    }

    public function status_denuncia($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        return $query->where('status_denuncia', $search);
    }

    public function filterdata($query, $search){
        $search = isset($search['search']) ? $search['search'] : '';
        $search = strtoupper($search);

        $IsEnlace =Auth::user()->isRole('ENLACE');
        $DependenciaIdArray = '';
        $DependenciaArray = '';

        IF ($IsEnlace){
            $DependenciaIdArray = Auth::user()->DependenciaIdArray;
            $filters['dependencia_id'] = $DependenciaIdArray;
        }elseif ( Auth::user()->isRole('CIUDADANO|DELEGADO') && !Auth::user()->isRole('Administrator|SysOp|test_admin') ){
            $filters['ciudadano_id'] = Auth::user()->id;
        }elseif ( Auth::user()->isRole('DELEGADOS') ){
            $filters['creadopor_id'] = Auth::user()->id;
        }elseif ( Auth::user()->isRole('DELEGADOS') ){
            $DelegadosIdArray = Auth::user()->DelegadosIdArray;
            $filters['creadopor_id'] = $DelegadosIdArray;
        }else{
            $filters['search'] = "";
        }
        session(['IsEnlace' => $IsEnlace]);
        session(['DependenciaArray' => $DependenciaIdArray]);
//        session(['DependenciaArray' => $DependenciaArray]);
//        session(['DependenciaIdArray' => $DependenciaIdArray]);

//        $filters['ambito_dependencia'] = session::get('ambito_dependencia');
//        $filters['ambito_estatus'] = session::get('ambito_estatus') ;
//
        //dd($filters);

        return $query->ambitoFilterBy($filters);


    }


}
