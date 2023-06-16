<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 29/11/18
 * Time: 08:43 AM
 */

namespace App\Filters\Catalogo\Domicilio;


use App\Filters\Common\QueryFilter;

class UbicacionFilter extends QueryFilter
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
            $query
                ->orWhereHas('calle', function ($q) use ($search) {
                    $q->whereRaw("UPPER(calle) like ?", "%{$search}%");
                })
                ->orWhereHas('colonia', function ($q) use ($search) {
                    $q->whereRaw("UPPER(colonia) like ?", "%{$search}%");
                })
                ->orWhereHas('comunidad', function ($q) use ($search) {
                    $q->whereRaw("UPPER(comunidad) like ?", "%{$search}%");
                })
                ->orWhereHas('ciudad', function ($q) use ($search) {
                    $q->whereRaw("UPPER(ciudad) like ?", "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%");
        });

    }









}
