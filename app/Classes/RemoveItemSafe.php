<?php
/*
 * Copyright (c) 2021. Realizado por Carlos Hidalgo
 */

namespace App\Classes;

use App\Models\Catalogos\Area;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Origen;
use App\Models\Catalogos\Prioridad;
use App\Models\Catalogos\Servicio;
use App\Models\Catalogos\Subarea;
use App\Models\Denuncias\Denuncia;
use App\User;
use Illuminate\Support\Facades\Response;

class RemoveItemSafe
{

    static function RemoveItemObject($Item, $Field, $Value){
        $arrObj=[];
        switch ($Field){
            case 'ciudadano_id':
            case 'creadopor_id':
            case 'modificadopor_id':
            case 'servicio_id':
            case 'prioridad_id':
            case 'origen_id':
            case 'estatus_id':
            case 'ubicacion_id':
                $arrObj=[Denuncia::class];
                break;
            case 'area_id':
                $arrObj=[Subarea::class];
                break;
            case 'subarea_id':
                $arrObj=[Servicio::class];
                break;
            case 'dependencia_id':
                $arrObj=[Area::class,Denuncia::class];
                break;
        }
        if ( count($arrObj) > 0 ){
            foreach ($arrObj as $Class)
            $obj = $Class::query()->where($Field,$Value)->get();
            if ( count($obj) == 0 ){
                if (!$Item->trashed()) {
                    $Item->forceDelete();
                } else {
                    $Item->forceDelete();
                }
                return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
            } else {
                return Response::json(['mensaje' => 'No se puede eliminar este objeto', 'data' => 'Error', 'status' => '200'], 200);
            }
        }else{
            return Response::json(['mensaje' => 'Nada que eliminar', 'data' => 'Error', 'status' => '200'], 200);
        }

    }

}
