<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 21/11/18
 * Time: 06:36 PM
 */

namespace App\Classes;


use App\User;
use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\Auth;

class FiltersRulesBySearch
{

    public function filterRulesDenunciaBySearch(Request $request){
        $data = $request->all(['search']);
        $data['search']   = $data['search'] ?? "";
        $filters = [
            'filterdata' => $data['search'],
        ];

//        dd($filters);

        return $filters;

    }

}
