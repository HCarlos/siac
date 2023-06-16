<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 30/11/18
 * Time: 01:03 PM
 */

namespace App\Filters\Denuncia;


use App\Filters\Common\QueryFilter;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DenunciamobileFilter extends QueryFilter
{


    public function rules(): array{
        return [
            'search'                 => '',
            'dependencia_id'         => '',
            'servicio_id'            => '',
            'estatus_id'             => '',
        ];
    }

//'fecha_movimiento_desde' => '',
//'fecha_movimiento_hasta' => '',

    public function search($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper($search);
        $filters  = $search;
        $F        = new FuncionesController();

//        $tsString = $F->string_to_tsQuery( strtoupper($filters),' & ');

        $filters      = strtolower($filters);
        $filters      = $F->str_sanitizer($filters);
        $tsString     = $F->string_to_tsQuery( strtoupper($filters),' & ');

        return $query->whereRaw("searchtextdenuncia @@ to_tsquery('spanish', ?)", [$tsString])
            ->orderByRaw("calle, num_ext, num_int, colonia, descripcion, referencia ASC");

    }

    public function servicio_id($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0" || trim($search) == "") {return $query;}
        return $query->whereHas('denuncia_servicios', function ($q) use ($query, $search) {
            return $q->where('servicio_id', (int)$search);
        });
    }

    public function estatus_id($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}

        return $query->whereHas('denuncia_estatus', function ($q) use ($query, $search) {
            return $q->where('estatu_id', (int)$search);
        });

    }

    public function dependencia($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}
        $search = explode('|',$search);
        return $query->orWhereHas('dependencia', function ($q) use ($search) {
            return $q->whereIn('dependencia',$search);
        });

    }


    function IsEnlace(){
        return Session::get('IsEnlace');
    }

    function getDependencia(){
            return $DependenciaArray = explode('|',Session::get('DependenciaArray'));
    }

    function getDependenciaId(){
        return $DependenciaIdArray = explode('|',Session::get('DependenciaIdArray'));
    }


}
