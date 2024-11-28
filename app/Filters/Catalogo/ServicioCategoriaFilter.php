<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 24/11/18
 * Time: 10:22 AM
 */

namespace App\Filters\Catalogo;


use App\Filters\Common\QueryFilter;

class ServicioCategoriaFilter extends QueryFilter
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
            $query->whereRaw("UPPER(categoria_servicios) like ?", "%{$search}%")
                ->orWhereRaw("UPPER(enlaces_unidades) like ?", "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        });
    }


}
