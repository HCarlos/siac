<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 26/11/18
 * Time: 11:25 AM
 */

namespace App\Filters\Catalogo;


use App\Filters\Common\QueryFilter;

class MedidaFilter extends QueryFilter
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
            $query->whereRaw("UPPER(medida) like ?", "%{$search}%")
//                ->orWhereHas('dependencia', function ($q) use ($search) {
//                    $q->whereRaw("UPPER(dependencia) like ?", "%{$search}%");
//                })
                ->orWhere('id', 'like', "%{$search}%");
        });
    }


}
