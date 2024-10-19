<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Estatu;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardEnlaceController extends Controller{

    protected $paginationTheme = 'bootstrap';
    protected $msg = "";
    protected $max_item_for_query = 250;
    protected $TotalColumna = 0;

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //

    /**
     * @param string $tableName
     */
    public function __construct(){
        $this->middleware('auth');
    }

    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);

        $search = $request->only(['desde','hasta']);
        //dd($search);
        if ( count($search) > 0 ){
            $FI = $search['desde'];
            $FF = $search['hasta'];
            $inicio = false;
        }else{
            $FI = Carbon::now()->subDays(7)->format('Y-m-d');
            $FF = Carbon::now()->format('Y-m-d');
            $inicio = true;
        }
        $fi = $FI;
        $ff = $FF;
        $FI = $FI.' 00:00:00';
        $FF = $FF.' 23:59:59';

        $estatusdep = null;
        $estatus = Estatu::all()->sortBy('orden_impresion')->pluck('abreviatura','orden_impresion')->toArray();
//        dd($estatus);
        $arr = array();
        $i = 0; $j = 0;
        $IsEnlace = Session::get('IsEnlace');
        if ($IsEnlace){
            $DependenciaIdArray = Session::get('DependenciaIdArray');

            //            $Dependencias = Dependencia::all()->whereIn('id',$DependenciaIdArray,false)->sortBy('dependencia');
            $deps = Dependencia::all()->whereIn('id',$DependenciaIdArray,false)->sortBy('id');

        }else{
            $deps = Dependencia::all()->sortBy('id');
        }

        foreach ($deps as $dep){
            $arr[$i][0] = $dep->id;
            $arr[$i][1] = $dep->dependencia;
            $arr[$i][2] = $dep->abreviatura;
            $arr[$i][3] = $dep->class_css;
            $j = 4;
            foreach ($estatus as $key => $value){
                $arr[$i][$j] = 0;
                $j++;
            }
            $this->TotalColumna = $j;
            $arr[$i][$j] = 0;
            $i++;

        }

//       dd($arr);

        foreach ($arr as $i => $value){

            $depid = $arr[$i][ 0 ];

            $rows  = Denuncia_Dependencia_Servicio::query()
                ->where('dependencia_id',$depid)
                ->whereHas('denuncia',function ($q) use ($FI, $FF) {
                     return $q->where("fecha_ingreso",'>=',$FI)->where("fecha_ingreso",'<=',$FF);
                })->get();

            if ($depid == 13 && !$inicio){
                $vas = "";
                foreach ($rows as $dp) {
                    $vas.=$dp->denuncia_id.', ' ;
                }
                //$arr[$i][1] = $vas;
            }
            $j = 0;
            $total = 0;
            foreach ($rows->sortByDesc('id')->unique('denuncia_id') as $dp){

                if ( $dp != null ){
                    $indice = intval($dp->estatu->orden_impresion) + 3;

                    $valor = intval( $arr[$i][$indice] ) ;

                    $nuevo_valor = $valor + 1;
                    $arr[$i][$indice] = $nuevo_valor;
                    $total++;
                }
            }
            $arr[$i][$this->TotalColumna] = $total;
        }

        $keys = array_column($arr, $this->TotalColumna);

        array_multisort($keys, SORT_DESC, $arr);

        $estatusdep = $arr;

        $cls = ['text-primary','text-secondary','text-success','text-danger','text-warning','text-info','text-light','text-dark'];
        return view('dashboard.partials.dashboard_enlace',
            [
                'totales' => $estatusdep,
                'arrCls' => $cls,
                'totalestatus' => $estatusdep,
                'estatus' => $estatus,
                'dependencias' => $deps,
                'FI' =>  date('d-m-Y', strtotime($fi)),
                'FF' =>  date('d-m-Y', strtotime($ff)),
            ]);

    }

}
