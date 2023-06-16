<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 26/11/18
 * Time: 12:05 PM
 */

namespace App\Filters\Catalogo;


use App\Filters\Common\QueryFilter;

class OrigenFilter extends QueryFilter
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
            $query->whereRaw("UPPER(origen) like ?", "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        });
    }



}
