<?php

namespace App\Http\Controllers\External\Denuncia;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AjaxController extends Controller{




    protected function getNotificationDependencias($dependencia_id_str){

        $res = str_replace( array( '\'','[', ']' ), '', $dependencia_id_str);

        //dd($res);

        $res = explode(',',$res);

        $items = Denuncia_Dependencia_Servicio::query()
            ->whereIn('dependencia_id', $res)
            ->where('fue_leida', false)
            ->get();
        $deps = array();
        foreach ($items as $item) {
            $Den    = Denuncia::find($item->denuncia_id);
            $Dep    = Dependencia::find($item->dependencia_id);
            $Srv    = Servicio::find($item->servicio_id);
            $UC     = User::find($item->creadopor_id);
            $Estatu = Estatu::find($item->estatu_id);
            $F = new FuncionesController();
            $deps[] = [
                'denuncia_id'      => $item->denuncia_id,
                'denuncia'         => $Den->descripcion,
                'dependencia_id'   => $item->dependencia_id,
                'dependencia'      => $Dep->dependencia,
                'abreviatura'      => $Dep->abreviatura,
                'servicio_id'      => $item->servicio_id,
                'servicio'         => $Srv->servicio,
                'estatu_id'        => $item->estatu_id,
                'estatu'           => $Estatu->estatus,
                'creadopor_id'     => $item->creadopor_id,
                'creadopor'        => $UC->Fullname,
                'fecha_movimiento' => Carbon::parse($item->fecha_movimiento)->format('Y-m-d H:i:s'),
                'observaciones'    => $item->observaciones,
                'favorable'        => $item->favorable,
                'fue_leida'        => $item->fue_leida,
            ];
        }

        // dd( $deps );

        if ( count($deps) > 0 ) {
            return Response::json(['mensaje' => 'OK', 'data' => $deps, 'status' => '200'], 200);
        } else {
            return Response::json(['mensaje' => 'Error', 'data' => null, 'status' => '200'], 200);
        }
    }


}
