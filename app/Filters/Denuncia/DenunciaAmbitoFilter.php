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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DenunciaAmbitoFilter extends QueryFilter
{


    public function rules(): array{
        return [
            'status_denuncia'        => '',
            'ambito_dependencia'     => '',
            'ambito_estatus'         => '',
            'search'                 => '',
            'search_google'          => '',
            'curp'                   => '',
            'ciudadano'              => '',
            'id'                     => '',
            'desde'                  => '',
            'hasta'                  => '',
            'dependencia_id'         => '',
            'prioridad_id'           => '',
            'servicio_id'            => '',
            'centro_localidad_id'    => '',
            'origen_id'              => '',
            'estatus_id'             => '',
            'fecha_movimiento'       => '',
            'ciudadano_id'           => '',
            'creadopor_id'           => '',
            'dependencia'            => '',
            'conrespuesta'           => '',
            'cerrado'                => '',
            'clave_identificadora'   => '',
            'uuid'                   => '',
            'latitud'                => '',
            'longitud'               => '',
            'solicitudesLocales'     => '',
        ];
    }

    public function status_denuncia($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        return $query->where('status_denuncia', (int)$search);
    }

//    public function ambito_dependencia($query, $search){
//        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
//        return $query->whereHas('dependencia', function ($q) use ($search) {
//            return $q->where('ambito_dependencia',(int)$search);
//        });
//    }
//
    public function ambito_dependencia($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
//        return $query->whereHas('dependencia', function ($q) use ($search) {
            return $query->where('ambito_dependencia',(int)$search);
//        });
    }


    public function ambito_estatus($query, $search){
        if (is_null($search) || empty($search) || trim($search) === "") {return $query;}
//            if ((int)$search <> 0){
//                return $query->where('ue_id', (int)$search );
//            }
//        DD($search);
        return $query->where('ue_id',$search );

//        return $query->whereHas('ultimo_estatus', function ($q) use ($search) {
//            return $q->where('id',$search);
//        });


    }


    public function search($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}

        $search = trim($search); // Eliminar espacios en blanco innecesarios
        $search = addslashes($search); // Escapar caracteres especiales

        return $query->whereRaw("gd_searchtext @@ plainto_tsquery('spanish', ?)", [$search]
                    )->orderByRaw("descripcion, referencia, search_google, gd_ubicacion ");

    }

    public function search_google($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}

        $search = trim($search); // Eliminar espacios en blanco innecesarios
        $search = addslashes($search); // Escapar caracteres especiales

        return $query->whereRaw("calle_y_numero_searchtext @@ plainto_tsquery('spanish', ?)", [$search]
        )->orderByRaw("search_google");

    }

    public function curp($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $search = strtoupper($search);

        return $query->where("curp_ciudadano",strtoupper(trim($search)));

//        return $query->whereHas('ciudadano_simple', function ($q) use ($search) {
//           return $q->where("curp",strtoupper(trim($search)));
//        });



     }

    public function ciudadano($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        return $query->whereHas('ciudadano_simple', function ($q) use ($search) {
            $filters  = $search;
            $F        = new FuncionesController();
            $tsString = $F->string_to_tsQuery( $filters,' & ');
            return $q->whereRaw("searchtext @@ to_tsquery('spanish', ?)", [$tsString]);
        });
    }

    public function id($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        return $query->where('id', $search);
    }

    public function desde($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $date = Carbon::createFromFormat('Y-m-d', $search)->toDateString();
        $date = $date.' 00:00:00';
        return $query->whereDate('fecha_ingreso', '>=', $date);
    }

    public function hasta($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "") {return $query;}
        $date = Carbon::createFromFormat('Y-m-d', $search)->toDateString();
        $date = $date.' 23:59:59';
        return $query->whereDate('fecha_ingreso', '<=', $date);
    }

    public function dependencia_id($query, $search){
        if (!auth()->user()->hasAnyPermission(['buscar_solo_en_su_ámbito'])) {
            if (is_null($search) || empty($search) || (isset($search) == false)) {
                return $query;
            }
        }
        if ( !is_array($search) ){
            if ((int)$search === 0){
                $search = Auth::user()->DependenciaIdArray;
            }
        }

        if ( is_array($search) ){
            return $query->whereIn('due_id', $search);
        }else{
            return $query->where('due_id', (int)$search);
        }
    }

    public function prioridad_id($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0" || trim($search) == "") {return $query;}
        return $query->where('prioridad_id', (int)$search);
    }


    public function servicio_id($query, $search){
        if (is_null($search) || empty($search) || (isset($search) == false)) {return $query;}
        if ( !is_array($search) ){
            if ((int)$search === 0){
                $search = Auth::user()->ServicioIdArray;
            }
        }
        if ( is_array($search) ){
            return $query->whereIn('sue_id', $search);
        }
        return $query->where('sue_id', (int)$search);
    }

    public function centro_localidad_id($query, $search){
        if (is_null($search) || empty ($search) || trim($search) === "0") {return $query;}
        return $query->where('centro_localidad_id', (int)$search);
    }


    public function estatus_id($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}
//            return $query->where('ue_id', (int)$search);
        return $query->where('estatu_id', (int)$search);
    }

    public function fecha_movimiento($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}

//        dd($search);

            $cad = explode('|',$search);

            $fdesde = $cad[0];
            $fhasta = $cad[1];
            $estatu = (int)$cad[2];
            $depend = (int)$cad[3];
            $date1 = Carbon::createFromFormat('Y-m-d', $fdesde)->toDateString();
            $date1 .= ' 00:00:00';
            $date2 = Carbon::createFromFormat('Y-m-d', $fhasta)->toDateString();
            $date2 .= ' 23:59:59';

        return $query->whereHas('ultimo_estatu_denuncia_dependencia_servicio', function ($q) use ($search, $date1, $date2, $estatu, $depend) {
            $arr      = Auth::user()->DependenciaIdArray;
            $arrAbrev = Auth::user()->DependenciaAbreviaturaArray;
//            dd($arrAbrev);
            if (auth()->user()->hasAnyPermission(['buscar_solo_en_su_ámbito'])) {
                if ($estatu > 0){
                    if ( is_array($arr) ) return $q->whereIn('dependencia_id',$arr)->where('estatu_id', $estatu)->whereDate('fecha_movimiento', '>=', $date1)->whereDate('fecha_movimiento', '<=', $date2);
                    else {
                        if ($arr > 0) return $q->where('dependencia_id', $arr)->where('estatu_id', $estatu)->whereDate('fecha_movimiento', '>=', $date1)->whereDate('fecha_movimiento', '<=', $date2);
                        else return $q->where('estatu_id', $estatu)->whereDate('fecha_movimiento', '>=', $date1)->whereDate('fecha_movimiento', '<=', $date2);
                    }
                }
            }else{
                if ($estatu > 0){
                    if ($depend > 0)
                        return $q
                            ->where('dependencia_id', $depend)
                            ->where('estatu_id', $estatu)
                            ->whereDate('fecha_movimiento', '>=', $date1)
                            ->whereDate('fecha_movimiento', '<=', $date2);
                    else return $q->where('estatu_id', $estatu)->whereDate('fecha_movimiento', '>=', $date1)->whereDate('fecha_movimiento', '<=', $date2);
                }else{
                    if ($depend > 0) return $q->where('dependencia_id', $depend)->whereDate('fecha_movimiento', '>=', $date1)->whereDate('fecha_movimiento', '<=', $date2);
                    else return $q->whereDate('fecha_movimiento', '>=', $date1)->whereDate('fecha_movimiento', '<=', $date2);
                }
            }
        });

    }

    public function origen_id($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}
        return $query->where('origen_id', $search);
    }

    public function ciudadano_id($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}
        return $query->where('ciudadano_id', $search);
    }

    public function creadopor_id($query, $search){
//        if (is_null($search) || empty ($search) || trim($search) === "0") {return $query;}

        if (is_null($search) || empty($search) || (isset($search) == false)) {
            return $query;
        }

        if ( !is_array($search) ){
            if ((int)$search === 0){
                $search = Auth::user()->DelegadosIdArray;
            }
        }


        if ( is_array($search) ){
            return $query->whereIn('creadopor_id', $search);
        }else{
            return $query->where('creadopor_id', (int)$search);
        }


    }

    public function dependencia($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}
        $search = explode('|',$search);
//        return $query->orWhereHas('dependencia', function ($q) use ($search) {
            return $query->whereIn('dependencia',$search);
//        });

    }

    public function conrespuesta($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}
        $search = explode('|',$search);
        if ($search==true)
            return $query->has('denuncia_estatus','>',1)->withCount('denuncia_estatus');
    }

    public function cerrado($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}
        return $query->orWhere('cerrado',settype($search, 'boolean'));
    }

    public function clave_identificadora($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}
        return $query->orWhere('clave_identificadora',$search);
    }

    public function uuid($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}
        $search = strtolower(trim($search));
        return $query->orWhere('uuid',trim($search));
    }

    function IsEnlace(){
        return Session::get('IsEnlace');
    }

    public function solicitudesLocales($query, $search){
        if (is_null($search) || empty ($search) || trim($search) == "0") {return $query;}

        $cad = explode('|',$search);
        $latitud = $cad[1];
        $longitud = $cad[2];
        return $query
            ->where('latitud', $latitud)
            ->where('longitud', $longitud);

    }



}
