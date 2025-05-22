<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Filters\Denuncia\Count;

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

        $IsEnlace               = Auth::user()->isRole('ENLACE') ?? false;
        $IsDelegados            = Auth::user()->isRole('DELEGADOS');
        $IsCoordinadorDelegados = Auth::user()->isRole('COORDINACION_DE_DELEGADOS');
        $DelegadosIdArray = [];
        $DependenciaIdArray = '';
        $DependenciaArray = '';

        IF ($IsEnlace){
            $ServicioIdArray = Auth::user()->ServicioIdArray;
            if (count($ServicioIdArray) > 0){
                $filters['servicio_id'] = $ServicioIdArray;
            }else{
                $DependenciaIdArray = Auth::user()->DependenciaIdArray;
                $filters['dependencia_id'] = $DependenciaIdArray;
            }
        }elseif ( Auth::user()->isRole('CIUDADANO|DELEGADO') && !Auth::user()->isRole('Administrator|SysOp|test_admin') ){
            $filters['ciudadano_id'] = Auth::user()->id;
        }elseif ( $IsDelegados ){
            $filters['creadopor_id'] = Auth::user()->id;
        }elseif ( $IsCoordinadorDelegados ){
            $DelegadosIdArray = Auth::user()->DelegadosIdArray;
            $filters['creadopor_id'] = $DelegadosIdArray;
        }else{
            $filters['search'] = "";
        }
        session(['IsEnlace' => $IsEnlace]);
        session(['DependenciaArray' => $DependenciaIdArray]);
        session(['DelegadosIdArray' => $DelegadosIdArray]);

        $filters['ambito_dependencia'] = Session::get('ambito_dependencia');
//        $filters['ambito_estatus'] = Session::get('ambito_estatus');

//        dd($filters);

        return $query->ambitoFilterBy($filters);


    }


}
