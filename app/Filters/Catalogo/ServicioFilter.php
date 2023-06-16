<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 26/11/18
 * Time: 01:22 PM
 */

namespace App\Filters\Catalogo;


use App\Filters\Common\QueryFilter;

class ServicioFilter extends QueryFilter
{
    public function rules(): array{
        return [
            'search' => '',
        ];
    }

    public function search($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper($search);
//        dd($search);

//        return $query->where(function ($query) use ($search) {
//            $query->where('servicio','like', '%{$search}%')
//                ->whereHas('subareas', function ($q) use ($search) {
//                    $q->where('subarea', 'like', '%{$search}%')
//                        ->orWhereHas('areas', function ($r) use ($search) {
//                            $r->where('area','like', '%{$search}%')
//                                ->orWhereHas('dependencias', function ($s) use ($search) {
//                                    $s->where('dependencia','like', '%${search}%')
//                                        ->orWhere('abreviatura','like', '%{$search}%');
//                                });
//                        });
//                })
//                ->orWhere('id', (int) $search);
//        });


//        return $query->where(function ($query) use ($search) {
//            $query->whereRaw("UPPER(servicio) like ?", "%{$search}%")
//                ->whereHas('subareas', function ($q) use ($search) {
//                    $q->whereRaw("UPPER(subarea) like ?", "%{$search}%")
//                        ->orWhereHas('areas', function ($r) use ($search) {
//                            $r->whereRaw("UPPER(area) like ?", "%{$search}%")
//                                ->orWhereHas('dependencias', function ($s) use ($search) {
//                                    $s->whereRaw("UPPER(dependencia) like ?", "%{$search}%")
//                                        ->orWhereRaw("UPPER(abreviatura) like ?", "%{$search}%");
//                            });
//                        });
//                    })
//                ->orWhere('id', (int) $search);
//        });


        return $query->where(function ($query) use ($search) {
            $query->whereRaw("UPPER(servicio) like ?", "%{$search}%")
                ->orWhereRaw("UPPER(subarea) like ?", "%{$search}%")
                ->orWhereRaw("UPPER(area) like ?", "%{$search}%")
                ->orWhereRaw("UPPER(dependencia) like ?", "%{$search}%")
                ->orWhere("abreviatura_dependencia", $search)
                ->orWhere('id', (int) $search);
        });



        //        ->orWhereHas('medidas', function ($q) use ($search) {
//            $q->whereRaw("UPPER(medida) like ?", "%{$search}%");
//        })


    }
}
