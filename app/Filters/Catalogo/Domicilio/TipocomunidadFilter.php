<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 27/11/18
 * Time: 02:27 PM
 */

namespace App\Filters\Catalogo\Domicilio;


use App\Filters\Common\QueryFilter;

class TipocomunidadFilter extends QueryFilter
{


    public function rules(): array{
        return [
            'search' => '',
        ];
    }

    public function search($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper($search);
        return $query->where(function ($query) use ($search) {
            $query->whereRaw("UPPER(tipocomunidad) like ?", "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        });
    }




}
