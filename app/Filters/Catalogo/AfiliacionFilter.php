<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 27/11/18
 * Time: 08:21 AM
 */

namespace App\Filters\Catalogo;


use App\Filters\Common\QueryFilter;

class AfiliacionFilter extends QueryFilter
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
            $query->whereRaw("UPPER(afiliacion) like ?", "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        });
    }


}
