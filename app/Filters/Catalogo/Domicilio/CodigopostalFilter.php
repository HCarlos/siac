<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 27/11/18
 * Time: 01:19 PM
 */

namespace App\Filters\Catalogo\Domicilio;


use App\Filters\Common\QueryFilter;

class CodigopostalFilter extends QueryFilter
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
            $query->whereRaw("UPPER(codigo) like ?", "%{$search}%")
                ->orWhereRaw("UPPER(cp) like ?", "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        });
    }



}
