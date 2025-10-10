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

class FiltersRules
{

    public function filterRulesDenuncia(Request $request){
        $data = $request->all(
            ['ambito_estatus','ambito_dependencia','curp','ciudadano','id','desde','hasta','prioridad_id','dependencia_id',
                'servicio_id','estatus_id','creadopor_id','incluirFecha','conRespuesta','clave_identificadora','uuid',
                'incluirFechaMovto','origen_id','ciudadano_id','centro_localidad_id',
                'solicitudesLocales','latitud','longitud','creadopor_id_ue'
            ]);
        $data['status_denuncia']      = 1;
        $data['ambito_dependencia']   = $data['ambito_dependencia']   == null ? "" : $data['ambito_dependencia'];
        $data['ambito_estatus']       = $data['ambito_estatus']       == null ? "" : $data['ambito_estatus'];
        $data['curp']                 = $data['curp']                 == null ? "" : $data['curp'];
        $data['ciudadano']            = $data['ciudadano']            == null ? "" : $data['ciudadano'];
        $data['id']                   = $data['id']                   == null ? "" : $data['id'];
        $data['desde']                = $data['desde']                == null ? "" : $data['desde'];
        $data['hasta']                = $data['hasta']                == null ? "" : $data['hasta'];
        $data['incluirFecha']         = $data['incluirFecha']         == null ? "" : $data['incluirFecha'];
        $data['incluirFechaMovto']    = $data['incluirFechaMovto']    == null ? "" : $data['incluirFechaMovto'];
        $data['conRespuesta']         = $data['conRespuesta']         == null ? "" : $data['conRespuesta'];
        $data['clave_identificadora'] = $data['clave_identificadora'] == null ? "" : $data['clave_identificadora'];
        $data['uuid']                 = $data['uuid']                 == null ? "" : $data['uuid'];
        $data['ciudadano_id']         = $data['ciudadano_id']         == null ? "" : $data['ciudadano_id'];
        $data['creadopor_id_ue']      = $data['creadopor_id_ue']      == null ? "" : $data['creadopor_id_ue'];
        $data['centro_localidad_id']  = $data['centro_localidad_id']  == null ? "" : $data['centro_localidad_id'];

        $data['dependencia_id']       = $data['dependencia_id']       == "0" ? "" : $data['dependencia_id'];
        $data['prioridad_id']         = $data['prioridad_id']         == "0" ? "" : $data['prioridad_id'];
        $data['origen_id']            = $data['origen_id']            == "0" ? "" : $data['origen_id'];

        $data['servicio_id']          = $data['servicio_id']          == "" || $data['servicio_id']    == "0'" ? "" : $data['servicio_id'];
        $data['estatus_id']           = $data['estatus_id']           == "0" ? "" : $data['estatus_id'];
        $data['creadopor_id']         = $data['creadopor_id']         == "0" ? "" : $data['creadopor_id'];

        $data['solicitudesLocales']   = $data['solicitudesLocales']   == null ? "" : $data['solicitudesLocales'];
        $data['latitud']              = $data['latitud']              == null ? "" : $data['latitud'];
        $data['longitud']             = $data['longitud']             == null ? "" : $data['longitud'];

        $filters = [
            'status_denuncia'    => $data['status_denuncia'],
            'ambito_dependencia' => $data['ambito_dependencia'],
            'ambito_estatus'     => $data['ambito_estatus'],
            'curp'               => $data['curp'],
            'ciudadano'          => $data['ciudadano'],
            'id'                 => $data['id'],
        ];
        if ($data['incluirFecha'] != null){
            $filters = array_merge($filters, ['desde' => $data['desde'], 'hasta' => $data['hasta'] ] );
        }
        if ($data['incluirFechaMovto'] != null){
            $filters = array_merge($filters, ['fecha_movimiento' => $data['desde'].'|'.$data['hasta'].'|'.$data['estatus_id'].'|'.$data['dependencia_id'] ] );
        }

        if ($data['solicitudesLocales'] != null){
            $filters = array_merge($filters, ['solicitudesLocales' => $data['solicitudesLocales'].'|'.$data['latitud'].'|'.$data['longitud']]);
            $filters = array_merge($filters, ['latitud' => $data['latitud']]);
            $filters = array_merge($filters, ['longitud' => $data['longitud']]);
        }

        if ($data['dependencia_id'] === ""){
            $IsEnlace =Auth::user()->isRole('ENLACE');
            IF ($IsEnlace) {
                $DependenciaIdArray = Auth::user()->DependenciaIdArray;
                $filters = array_merge($filters, ['dependencia_id' => $DependenciaIdArray]);
            }else{
                $filters = array_merge($filters, ['dependencia_id' => $data['dependencia_id']]);
            }
        }else{
            $filters = array_merge($filters, ['dependencia_id' => $data['dependencia_id']]);
        }

        $filters = array_merge($filters, [
            'ciudadano_id'         => $data['ciudadano_id'],
            'creadopor_id_ue'      => $data['creadopor_id_ue'],
            'centro_localidad_id'  => $data['centro_localidad_id'],
            'origen_id'            => $data['origen_id'],
            'servicio_id'          => $data['servicio_id'],
            'estatus_id'           => $data['estatus_id'],
            'prioridad_id'         => $data['prioridad_id'],
            'creadopor_id'         => $data['creadopor_id'],
            'conrespuesta'         => $data['conRespuesta'],
            'clave_identificadora' => $data['clave_identificadora'],
            'uuid'                 => $data['uuid'],
            'incluirFecha'         => $data['incluirFecha'],
            'incluirFechaMovto'    => $data['incluirFechaMovto'],
        ]);

//        dd($filters);

        return $filters;

    }

}
