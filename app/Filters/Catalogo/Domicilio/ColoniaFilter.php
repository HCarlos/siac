<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 28/11/18
 * Time: 10:40 AM
 */

namespace App\Filters\Catalogo\Domicilio;


use App\Filters\Common\QueryFilter;

class ColoniaFilter extends QueryFilter
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
            $query->whereRaw("UPPER(colonia) like ?", "%{$search}%")
                ->orWhereHas('codigoPostal', function ($q) use ($search) {
                    $q->whereRaw("UPPER(codigo) like ?", "%{$search}%");
                })
                ->orWhereHas('comunidad', function ($q) use ($search) {
                    $q->whereRaw("UPPER(comunidad) like ?", "%{$search}%");
                })
                ->orWhereHas('tipoComunidad', function ($q) use ($search) {
                    $q->whereRaw("UPPER(tipocomunidad) like ?", "%{$search}%");
                })
                ->orWhere('id', 'like', "%{$search}%");
        });
    }




}
