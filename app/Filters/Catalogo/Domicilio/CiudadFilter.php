<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 27/11/18
 * Time: 10:00 AM
 */

namespace App\Filters\Catalogo\Domicilio;


use App\Filters\Common\QueryFilter;

class CiudadFilter extends QueryFilter
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
            $query->whereRaw("UPPER(ciudad) like ?", "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        });
    }



}
