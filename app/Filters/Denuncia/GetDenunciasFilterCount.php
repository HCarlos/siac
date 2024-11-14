<?php
/*
 * Copyright (c) 2021. Realizado por Carlos Hidalgo
 */

namespace App\Filters\Denuncia;

use App\Filters\Common\QueryFilter;
use Illuminate\Support\Facades\Auth;

class GetDenunciasFilterCount extends QueryFilter{


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
        IF ($IsEnlace){
            $DependenciaIdArray = Auth::user()->DependenciaIdArray;
            $filters['dependencia_id'] = $DependenciaIdArray;
        }elseif ( Auth::user()->isRole('CIUDADANO|DELEGADO') && !Auth::user()->isRole('Administrator|SysOp') ){
            $filters['ciudadano_id'] = Auth::user()->id;
        }else{
            $filters['search'] = "";
        }
        session(['IsEnlace' => $IsEnlace]);
        session(['DependenciaArray' => $DependenciaIdArray]);
        //dd($filters);
        return $query->filterBy($filters);

    }


}
