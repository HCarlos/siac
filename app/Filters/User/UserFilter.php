<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 21/11/18
 * Time: 06:32 PM
 */

namespace App\Filters\User;

use App\Filters\Common\QueryFilter;
use App\Http\Controllers\Funciones\FuncionesController;

class UserFilter extends QueryFilter {

    public function rules(): array{
        return [
            'search' => '',
            'roles' => '',
            'becas' => '',
        ];
    }

    public function search($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search   = strtoupper($search);
        $filters  = $search;
        $F        = new FuncionesController();
        $tsString = $F->string_to_tsQuery( strtoupper($filters),' & ');
        return $query->whereRaw("searchtext @@ to_tsquery('spanish', ?)", [$tsString]);
//            ->orderByRaw("ts_rank(searchtext, to_tsquery('spanish', ?)) DESC", [$tsString]);

//        ->orWhereHas('roles', function ($q) use ($search) {
//            return $q->whereRaw("UPPER(name) like ?", "%{$search}%");
//        })
//        ->orWhereHas('user_adress', function ($q) use ($search) {
//            return $q->whereRaw("UPPER(calle) like ?", "%{$search}%")
//                ->orWhereRaw("UPPER(colonia) like ?", "%{$search}%")
//                ->orWhereRaw("UPPER(localidad) like ?", "%{$search}%");
//        })
//        ->orWhere('id', 'like', "%{$search}%")


    }

    public function roles($query, $roles){
        if (is_null($roles) ) {return $query;}
        if (empty ($roles)) {return $query;}
        return $query->whereHas('roles', function ($q) use ($roles) {
            $q->whereIn('role_id', $roles);
        });
    }

    public function becas($query, $beca){
        if (is_null($beca) || empty ($beca) || $beca == 'beca_none') {return $query;}
        return $query->whereHas('user_becas', function ($q) use ($beca) {
            $q->where($beca,'>', 0);
        });
    }


}
