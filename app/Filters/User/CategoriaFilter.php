<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 23/11/18
 * Time: 02:46 PM
 */

namespace App\Filters\User;

use App\Filters\Common\QueryFilter;

class CategoriaFilter extends QueryFilter {

    public function rules(): array{
        return [
            'search' => '',
        ];
    }

    public function search($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper($search);
        return $query->where(function ($query) use ($search) {
            $query->whereRaw("UPPER(categoria) like ?", "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        });
    }

}
