<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 27/11/18
 * Time: 05:07 PM
 */

namespace App\Filters\Catalogo\Domicilio;


use App\Filters\Common\QueryFilter;

class ComunidadFilter extends QueryFilter
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
            $query->whereRaw("UPPER(comunidad) like ?", "%{$search}%")
                ->orWhereHas('delegado', function ($q) use ($search) {
                    $q->whereRaw("CONCAT(ap_paterno,' ',ap_materno,' ',nombre) like ?", "%{$search}%");
                })
                ->orWhereHas('tipoComunidad', function ($q) use ($search) {
                    $q->whereRaw("UPPER(tipocomunidad) like ?", "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%");
        });
    }




}
