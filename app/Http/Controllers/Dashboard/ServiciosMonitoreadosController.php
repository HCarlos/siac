<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\Dashboard;

use App\Classes\Denuncia\ActualizaEstadisticasARO;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\CentroLocalidad;
use App\Models\Denuncias\_viDepDenServEstatus;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServiciosMonitoreadosController extends Controller{

    public function __construct(){
        ini_set('max_execution_time', 300);
        $this->middleware('auth');
    }

    protected function index(Request $request){

        $data = $request->all();

        $f = new FuncionesController();

        if ($data === []){
            $start_date = Carbon::now();
            $start_date = $start_date->format('Y-m-d');
            $end_date = $start_date;
            $filter = 'hoy';
        }else{
            switch ($data['filter']) {
                case 'hoy':
                    $start_date = Carbon::now();
                    $start_date = $start_date->format('Y-m-d');
                    $end_date = $start_date;
                    break;
                case 'mes':
                    $start_date = Carbon::now()->startOfMonth();
                    $start_date = $start_date->format('Y-m-d');
                    $end_date = Carbon::now()->endOfMonth();
                    $end_date =  $end_date->format('Y-m-d');
                    break;
                case 'anio':
                    $start_date = Carbon::now()->startOfYear();
                    $start_date = $start_date->format('Y-m-d');
                    $end_date = Carbon::now()->endOfYear();
                    $end_date =  $end_date->format('Y-m-d');
                    break;
                default:
                    $start_date = $data['start_date'];
                    $end_date = $data['end_date'];
                    break;
            }
            $filter = $data['filter'];

        }

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['filter'] = $filter;

        $file_out = "file_servicios_principales_".$start_date.'_'.$end_date.'.json';
        $isExistFile = false; //Storage::disk('public')->exists($file_out);

        if ( ! $isExistFile) {


            // INICIA EL MODULO DE ESTATUS
            $arrEstatus = [
                (object)["ue_id" => 16, "Estatus"=> "RECIBIDA", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
                (object)["ue_id" => 19, "Estatus"=> "EN_PROCESO", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
                (object)["ue_id" => 17, "Estatus"=> "ATENDIDA", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
                (object)["ue_id" => 20, "Estatus"=> "RECHAZADA", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
                (object)["ue_id" => 18, "Estatus"=> "OBSERVADA", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
                (object)["ue_id" => 21, "Estatus"=> "CERRADO", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
                (object)["ue_id" => 22, "Estatus"=> "CERRADO POR RECHAZO", "Total"=> 0, "Unidades" => [],"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
            ];

            $ServiciosPrincipales = [483,508,476,503,479,466,567,568];

            $srv2 = static::getUltimoEstatus($start_date,$end_date,$ServiciosPrincipales);

//            dd($srv2);

            foreach ($arrEstatus as $a) {
                foreach ($srv2 as $d){
                    if ($d->ue_id === $a->ue_id) {
                        $a->Total = $d->data;
                        $arrU = [];
                        $ta = 0;
                        $tr = 0;

                        $vectorUnidades = [
                            (object)["Unidad" => "ALUMBRADO", "Unidad_Id" => 46,"Total" => 0,"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0, 'Total1'=>0,'a_tiempo_t1'=>0, 'con_rezago_t1'=>0],
                            (object)["Unidad" => "ESPACIOS PÚBLICOS", "Unidad_Id" => 49,"Total" => 0,"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0, 'Total1'=>0,'a_tiempo_t1'=>0, 'con_rezago_t1'=>0],
                            (object)["Unidad" => "LIMPIA", "Unidad_Id" => 50,"Total" => 0,"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0, 'Total1'=>0,'a_tiempo_t1'=>0, 'con_rezago_t1'=>0],
                            (object)["Unidad" => "OBRAS PÚBLICAS", "Unidad_Id" => 48,"Total" => 0,"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0, 'Total1'=>0,'a_tiempo_t1'=>0, 'con_rezago_t1'=>0],
                            (object)["Unidad" => "SAS", "Unidad_Id" => 47,"Total" => 0,"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0, 'Total1'=>0,'a_tiempo_t1'=>0, 'con_rezago_t1'=>0],
                        ];
                        $totalServ = 0;
                        foreach ($vectorUnidades as $key => $value) {
                            $f = static::getEstatusUE($start_date,$end_date,$value->Unidad_Id,$a->ue_id,$ServiciosPrincipales);
                            if ($f) {
                                if ($f->total > 0) {
                                    $vectorUnidades[$key]->Total = $f->total;
                                    $totalServ += $f->total;
                                }
                            }
                        }
                        foreach ($vectorUnidades as $key => $value) {
                            $total = $vectorUnidades[$key]->Total > 0 ? (($vectorUnidades[$key]->Total / $totalServ) * 100)  : 0;
                            $vectorUnidades[$key]->Porcentaje = (int) number_format($total, 0);
                        }

                        foreach ($vectorUnidades as $b) {
                            $f = static::getEstatusDependencia($start_date,$end_date,$b->Unidad_Id,$d->ue_id,$ServiciosPrincipales);
                            if ($f !== null) {
                                $b->Total = $f->data;
                            }
//                            if ($a->ue_id === 17) {
                                $arr = static::getAtiempoVsDestiempo($start_date,$end_date,$b->Unidad_Id,$a->ue_id,$ServiciosPrincipales);
                                $b->a_tiempo = $arr->atiempo ?? 0;
                                $b->con_rezago = $arr->conrezago ?? 0;
                                $ta += $arr->atiempo ?? 0;
                                $tr += $arr->conrezago ?? 0;
//                            }
                            $arrU[] = $b;
                        }
                        $a->Unidades = $arrU;
                        $a->a_tiempo = $ta;
                        $a->con_rezago = $tr;
                    }
                }
            }

            // SUmamos En proceso y Observadas
            foreach ($arrEstatus[1]->Unidades as $key => $uni) {
                $uni1 = $arrEstatus[1]->Unidades[$key]->Total ?? 0;
                $uni4 = $arrEstatus[4]->Unidades[$key]->Total ?? 0;
                $uni->Total1 = $uni1 + $uni4;
            }

            // Sumamos Atendidas y Cerradas
            foreach ($arrEstatus[2]->Unidades as $key => $uni) {
                $uni2 = $arrEstatus[2]->Unidades[$key]->Total ?? 0;
                $uni5 = $arrEstatus[5]->Unidades[$key]->Total ?? 0;

                $uniat2 = $arrEstatus[2]->Unidades[$key]->a_tiempo ?? 0;
                $uniat5 = $arrEstatus[5]->Unidades[$key]->a_tiempo ?? 0;

                $unicr2 = $arrEstatus[2]->Unidades[$key]->con_rezago ?? 0;
                $unicr5 = $arrEstatus[5]->Unidades[$key]->con_rezago ?? 0;

                $uni->Total1 = $uni2 + $uni5;
                $uni->a_tiempo_t1 = $uniat2 + $uniat5;
                $uni->con_rezago_t1 = $unicr2 + $unicr5;
            }

            // Sumamos Rechazadas y Cerrada por Rechazos
            foreach ($arrEstatus[3]->Unidades as $key => $uni) {
                $uni3 = $arrEstatus[3]->Unidades[$key]->Total ?? 0;
                $uni6 = $arrEstatus[6]->Unidades[$key]->Total ?? 0;
                $uni->Total1 = $uni3 + $uni6;
            }



//            dd($arrEstatus);

            // INICIA EL MODULO DE UNIDADES
            $vectorUnidades = [
                (object)["Unidad" => "ALUMBRADO", "Unidad_Id" => 46,"Total" => 0,"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
                (object)["Unidad" => "ESPACIOS PÚBLICOS", "Unidad_Id" => 49,"Total" => 0,"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
                (object)["Unidad" => "LIMPIA", "Unidad_Id" => 50,"Total" => 0,"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
                (object)["Unidad" => "OBRAS PÚBLICAS", "Unidad_Id" => 48,"Total" => 0,"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
                (object)["Unidad" => "SAS", "Unidad_Id" => 47,"Total" => 0,"Porcentaje" => 0,'a_tiempo'=>0, 'con_rezago'=>0],
            ];
            $totalServ = 0;
            foreach ($vectorUnidades as $key => $value) {
                $f = static::getEstatus($start_date,$end_date,$value->Unidad_Id,$ServiciosPrincipales);
                if ($f) {
                    if ($f->total > 0) {
                        $vectorUnidades[$key]->Total = $f->total;
                        $totalServ += $f->total;
                    }
                }
            }

            foreach ($vectorUnidades as $key => $value) {
                $total = $vectorUnidades[$key]->Total > 0 ? (($vectorUnidades[$key]->Total / $totalServ) * 100)  : 0;
                $vectorUnidades[$key]->Porcentaje = (int) number_format($total, 0);
            }

            // INICIA EL MODULO DE SERVICIOS
            $vectorServicios = [
                (object)["sue_id" => 483, "Servicio"=> "BACHEO DE VIALIDADES", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 508, "Servicio"=> "DESAZOLVE DE DRENAJE", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 476, "Servicio"=> "FUGA DE AGUA POTABLE", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 503, "Servicio"=> "RECOLECCIÓN DE RESIDUOS SÓLIDOS", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 479, "Servicio"=> "REPARACIÓN DE ALCANTARILLA", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 466, "Servicio"=> "REPARACIÓN DE LUMINARIAS", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 567, "Servicio"=> "RESANE CON ASFALTO", "Total"=> 0,"Porcentaje" => 0],
                (object)["sue_id" => 568, "Servicio"=> "RESANE CON CONCRETO HIDRÁULICO", "Total"=> 0,"Porcentaje" => 0],
            ];

            $totalServ = 0;
            foreach ($vectorServicios as $key => $value) {
                $f = static::getServiciosDependencia($start_date,$end_date,$value->sue_id);
                if ($f) {
                    if ($f->total > 0) {
                        $vectorServicios[$key]->Total = $f->total;
                        $totalServ += $f->total;
                    }
                }
            }

            foreach ($vectorServicios as $key => $value) {
                $total = $vectorServicios[$key]->Total > 0 ? (($vectorServicios[$key]->Total / $totalServ) * 100)  : 0;
                $vectorServicios[$key]->Porcentaje = (int) number_format($total, 0);
            }

            // INICIA EL MODULO DE GEOLOCALIZACIÓN
            $arrGeos = [];
            $arrDep = [];
            $arrDepServ = [];

            $arrUnidades = [46,47,48,49,50];
            $arrG = static::getGeoDenuncias($start_date,$end_date,$ServiciosPrincipales);
//            $arrG = static::getGeoDenuncias($start_date,$end_date,$arrUnidades);
            $initArr = true;

            $ArrSolicitudesInternasLabel = ["SAS", "LIMPIA"];
            $ArrSolicitudesInternasValue = [508833, 519442];

            $arrCoorDelegados = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['DELEGADOS', 'COORDINACION_DE_DELEGADOS']);
            })
                ->pluck('id')
                ->toArray();


            //DELEGADOS
//COORDINACION_DE_DELEGADOS


//            dd( $arrG[0] );

            foreach ($arrG as $g) {
                $paso = false;
//                if ( ! in_array($g->sue_id,$ServiciosPrincipales) ) {
//
//                    $arg = Denuncia_Dependencia_Servicio::
//                    where('denuncia_id',$g->id)
//                    ->where('dependencia_id',$g->dependencia_id)
//                    ->whereIn('servicio_id',$ServiciosPrincipales)
//                        ->orderByDesc('id')
//                        ->first();
//                    if ( $arg ) {
//                        $gg = DB::table("_vimovimientos")
//                            ->select(
//                                'id as ddse_id','denuncia_id as id','latitud','longitud','dependencia','abreviatura','servicio as servicio_ultimo_estatus',
//                                'nombre_corto_ss','ciudadano','fecha_ingreso','fecha_dias_ejecucion',
//                                'fecha_movimiento as fecha_ultimo_estatus', 'fecha_dias_maximos_ejecucion','estatus as ultimo_estatus',
//                                'servicio_id as sue_id','servicio as servicio_ultimo_estatus','ue_id','dependencia_id','uuid',
//                                'descripcion as denuncia','centro_localidad_id'
//                            )
//                            ->where('id', $arg->id)
//                            ->first();
//
////                        if ($g->id == 124541){
////                            dd($gg);
////                        }
//
//
//                            $paso = true;
//
//                    }
//
//                }else{
//                    $paso = true;
//                }
//
//                if ($paso) {

                    $fme1 = Carbon::parse($g->fecha_dias_ejecucion);
                    $fme2 = Carbon::parse($g->fecha_dias_maximos_ejecucion);
                    $fi = Carbon::parse($g->fecha_ingreso);
                    $fue = Carbon::parse($g->fecha_ultimo_estatus);

                    $icon = "";
                    foreach ($vectorUnidades as $u) {
                        if ($u->Unidad_Id = $g->dependencia_id) {
                            switch ($u->Unidad_Id) {
                                case 46:
                                    $icon = "lightbulb";
                                    break;
                                case 49:
                                    $icon = "tree";
                                    break;
                                case 50:
                                    $icon = "trash";
                                    break;
                                case 48:
                                    $icon = "person-digging";
                                    break;
                                case 47:
                                    $icon = "droplet";
                                    break;
                            }
                        }
                    }

                    $status = "white";
                    $dias_vencidos = 0;

                    $semaforo = ActualizaEstadisticasARO::semaforo_ultimo_estatus_off($g->ue_id, new DateTime($g->fecha_dias_maximos_ejecucion), new DateTime($g->fecha_ultimo_estatus));
                    $status = $semaforo['status'];
                    $dias_vencidos = $semaforo['dias_vencidos'];

                    $Colonia_Id = 0;
                    $Colonia = "";
                    $Delegacion_Id = 0;
                    $Delegacion = "";
                    $ColDel = "";
                    $ColDelId = 0;
                    $CenLoc = $g->centro_localidad_id;
                    if ($CenLoc != null || $CenLoc != "" || $CenLoc != 0) {
                        $Loc = CentroLocalidad::find($CenLoc);
                        $Colonia_Id = $Loc->colonia_id;
                        $Colonia = $Loc->ItemColonia();
                        $Delegacion_Id = $Loc->delegacion_id;
                        $Delegacion = $Loc->ItemDelegacion();
                        $ColDel = $Loc->ItemColoniaDelegacion();
                        $ColDelId = $Loc->id;
                    }

                    $arrGeos[] = (object)[
                        "ddse_id" => $g->id,
                        "denuncia_id" => $g->denuncia_id,
                        "denuncia" => $g->descripcion,
                        "latitud" => (float)$g->latitud,
                        "longitud" => (float)$g->longitud,
                        "dependencia_id" => $g->dependencia_id,
                        "dependencia" => $g->dependencia,
                        "abreviatura" => $g->abreviatura,
                        "sue_id" => $g->servicio_id,
                        "servicio" => $g->servicio,
                        "ciudadano" => $g->ciudadano,
                        "ue_id" => $g->ue_id,
                        "ultimo_estatus" => $g->estatus,
                        "fecha_ultimo_estatus" => Carbon::parse($g->fecha_ultimo_estatus)->format('d-m-Y H:i:s'),
                        "fecha_ingreso" => Carbon::parse($g->fecha_ingreso)->format('d-m-Y H:i:s'),
                        "fecha_ejecucion_minima" => Carbon::parse($g->fecha_dias_ejecucion)->format('d-m-Y H:i:s'),
                        "fecha_ejecucion_maxima" => Carbon::parse($g->fecha_dias_maximos_ejecucion)->format('d-m-Y H:i:s'),
                        "dias_a_tiempo" => Carbon::parse($g->fecha_dias_maximos_ejecucion)->diffInDays(Carbon::parse($g->fecha_ingreso)),
                        "type" => $status,
                        "icon" => $icon,
                        "dias_vencidos" => $dias_vencidos,
                        "uuid" => $g->uuid,
                        "colonia_id" => $Colonia_Id,
                        "colonia" => $Colonia,
                        "delegacion_id" => $Delegacion_Id,
                        "delegacion" => $Delegacion,
                        "colonia_delegacion" => $ColDel,
                        "colonia_delegacion_id" => $ColDelId
                    ];

                    if (!in_array($g->dependencia_id, array_column($arrDep, 'dependencia_id'), true)) {
                        $arrDep[] = ["dependencia_id" => $g->dependencia_id, "dependencia" => $g->dependencia];
                    }

                    if ($initArr) {
                        $arrDepServ[] = ["dependencia_id" => $g->dependencia_id, "dependencia" => $g->dependencia, "sue_id" => $g->servicio_id, "servicio" => $g->servicio];
                        $initArr = false;
                    } else {
                        $Encontrado = false;
                        foreach ($arrDepServ as $key => $value) {
                            if ($value['dependencia_id'] === $g->dependencia_id && $value['sue_id'] === $g->servicio_id) {
                                $Encontrado = true;
                            }
                        }
                        if (!$Encontrado) {
                            $arrDepServ[] = ["dependencia_id" => $g->dependencia_id, "dependencia" => $g->dependencia, "sue_id" => $g->servicio_id, "servicio" => $g->servicio];
                        }

                    }
//                }
            }

//            dd($arrGeos);



            // INICIA EL MODULO DE OTROS DATOS
            $arrGeos = collect($arrGeos);
            $total_geodenuncias = count($arrGeos);
            $cerradas = count($arrGeos->where('ue_id', 21));
            $cerradas_rechazo = count($arrGeos->where('ue_id', 22));
            $atendidas = count($arrGeos->where('ue_id', 17));
            $rechazadas = count($arrGeos->where('ue_id', 20));
            $observadas = count($arrGeos->where('ue_id', 18));
            $porcAtendidas = $total_geodenuncias > 0 ? (($atendidas / $total_geodenuncias) * 100)  : 0;
            $porcRechazadas = $total_geodenuncias > 0 ? (($rechazadas / $total_geodenuncias) * 100)  : 0;
            $porcPendientes = 100 - $porcAtendidas;
            $porcAtendidas = number_format($porcAtendidas, 2, '.', '');
            $porcPendientes = number_format($porcPendientes, 2, '.', '');
            $porcRechazadas = number_format($porcRechazadas, 2, '.', '');

            $otrosDatos = [
                (object)["total_geodenuncias" => $total_geodenuncias,
                "cerradas" => $cerradas,
                "cerradas_rechazo" => $cerradas_rechazo,
                "atendidas" => $atendidas,
                "rechazadas" => $rechazadas,
                "observadas" => $observadas,
                "porcAtendidas" => $porcAtendidas,
                "porcPendientes" => $porcPendientes,
                "porcRechazadas" => $porcRechazadas
                ]
            ];

            $localidades_centro = CentroLocalidad::query()
                ->orderBy('prefijo_colonia', 'asc')
                ->orderBy('colonia', 'asc')
                ->get();

            $arrLocDel = array();
            foreach ($localidades_centro as $item) {
                $arrLocDel[] = (object)[
                    'id' => $item->id,
                    "colonia_id" => $item->colonia_id,
                    "colonia"=> $item->ItemColonia(),
                    "delegacion_id" => $item->delegacion_id,
                    "delegacion"=> $item->ItemDelegacion(),
                    "colonia_delegacion"=>$item->ItemColoniaDelegacion(),
                ];
            }

            // SE OBTENEN LAS DELEGACIONES

            $delegaines_centro = CentroLocalidad::query()
                ->select('delegacion_id','prefijo_delegacion', 'delegacion')
                ->groupby('delegacion_id','prefijo_delegacion', 'delegacion')
                ->distinct()
                ->orderBy('prefijo_delegacion', 'asc')
                ->orderBy('delegacion', 'asc')
                ->get();

            $arrDel = array();
            foreach ($delegaines_centro as $item) {
                $arrDel[] = (object)[
                    "delegacion_id" => $item->delegacion_id,
                    "delegacion"=> $item->ItemDelegacion(),
                ];
            }

            // SE CONSTRUYE EL JSON GENERAL
            $arrJson = [
                (object)["estatus" => $arrEstatus],
                (object)["unidades" =>  collect($vectorUnidades)->sortByDesc('Total')->values()->all()],
                (object)["servicios" => $vectorServicios],
                (object)["georeferencias" => $arrGeos],
                (object)["otros" => $otrosDatos],
                (object)["filtro_unidades" => $arrDep],
                (object)["filtro_servicios" => $arrDepServ],
                (object)["filtro_colonias" => $arrLocDel],
                (object)["filtro_delegaciones" => $arrDel],
            ];

            $jsonData = json_encode($arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            Storage::disk('public')->put($file_out, $jsonData);
        }

        $f = new FuncionesController();

        $menu = $f->menuDashBoard(0);

        return view('dashboard.static.dashboard_static_servicios_principales',
            [
                'filter' => $filter,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'file_output' => $file_out ?? null,
                'menu' => $menu,
            ]);

    }


    // INICIA EL MODULO DE FUNCIONES AUXILIARES

    static function getUltimoEstatus($start_date,$end_date,$ServiciosPrincipales){
//        ->where("ambito_dependencia",2)
//        return DB::table("_viddss")
//            ->select(["ultimo_estatus as name", "ue_id", DB::raw("count(ue_id) as data")])
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->whereIn('sue_id', [483,508,476,503,479,466,567,568])
//            ->groupBy(["ultimo_estatus","ue_id"])
//            ->get();


        return DB::table("_vimov_filter_sm")
            ->select(["estatus as name", "estatu_id as ue_id", DB::raw("count(estatu_id) as data")])
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->whereIn('servicio_id', [483,508,476,503,479,466,567,568])
            ->groupBy(["estatus","estatu_id"])
            ->get();


    }

    static function getEstatusDependencia($start_date,$end_date,$dependencia_id,$ue_id,$ServiciosPrincipales){

//        return DB::table("_viddss")
//            ->select('abreviatura as label', DB::raw('count(dependencia_id) as data'))
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->where('ambito_dependencia',2)
//            ->where('dependencia_id',$dependencia_id)
//            ->whereIn('sue_id', $ServiciosPrincipales)
//            ->where('ue_id',$ue_id)
//            ->groupBy('abreviatura')
//            ->first();

        return DB::table("_vimov_filter_sm")
            ->select('abreviatura as label', DB::raw('count(dependencia_id) as data'))
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->where('dependencia_id',$dependencia_id)
            ->whereIn('servicio_id', $ServiciosPrincipales)
            ->where('estatu_id',$ue_id)
            ->groupBy('abreviatura')
            ->first();
    }
    static function getEstatus($start_date,$end_date,$dependencia_id,$ServiciosPrincipales){

//        return DB::table("_viddss")
//            ->select('dependencia_id as label', DB::raw('count(dependencia_id) as total'))
//            ->where('ambito_dependencia',2)
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->where('dependencia_id',$dependencia_id)
//            ->whereIn('sue_id', $ServiciosPrincipales)
//            ->groupBy('dependencia_id')
//            ->first();

        return DB::table("_vimov_filter_sm")
            ->select('dependencia_id as label', DB::raw('count(dependencia_id) as total'))
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->where('dependencia_id',$dependencia_id)
            ->whereIn('servicio_id', $ServiciosPrincipales)
            ->groupBy('dependencia_id')
            ->first();

    }
    static function getEstatusUE($start_date,$end_date,$dependencia_id,$ue_id,$ServiciosPrincipales){

//        return DB::table("_viddss")
//            ->select('dependencia_id as label', DB::raw('count(dependencia_id) as total'))
//            ->where('ambito_dependencia',2)
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->where('dependencia_id',$dependencia_id)
//            ->whereIn('sue_id', $ServiciosPrincipales)
//            ->where('ue_id',$ue_id)
//            ->groupBy('dependencia_id')
//            ->first();

        return DB::table("_vimov_filter_sm")
            ->select('dependencia_id as label', DB::raw('count(dependencia_id) as total'))
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->where('dependencia_id',$dependencia_id)
            ->whereIn('servicio_id', $ServiciosPrincipales)
            ->where('estatu_id',$ue_id)
            ->groupBy('dependencia_id')
            ->first();

    }

    static function getServiciosDependencia($start_date,$end_date,$sue_id){

//        return DB::table("_viddss")
//            ->select('abreviatura as label', DB::raw('count(sue_id) as total'))
//            ->where('ambito_dependencia',2)
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->where('sue_id',$sue_id)
//            ->groupBy('abreviatura')
//            ->first();

        return DB::table("_vimov_filter_sm")
            ->select('abreviatura as label', DB::raw('count(servicio_id) as total'))
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->where('servicio_id',$sue_id)
            ->groupBy('abreviatura')
            ->first();


    }

    static function getAtiempoVsDestiempo($start_date,$end_date,$unidad_id,$ue_id,$ServiciosPrincipales){

//        return DB::table("_viddss")
//            ->select(
//                DB::raw("SUM(CASE WHEN fecha_dias_ejecucion >= CURRENT_DATE THEN 1 ELSE 0 END) AS atiempo"),
//                DB::raw("SUM(CASE WHEN CURRENT_DATE > fecha_dias_ejecucion THEN 1 ELSE 0 END) AS conrezago")
//            )
//            ->where('ambito_dependencia', 2)
//            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])
//            ->where('dependencia_id', $unidad_id)
//            ->whereIn('sue_id', $ServiciosPrincipales)
//            ->where('ue_id', $ue_id)
//            ->groupBy('ue_id')
//            ->first();

        return DB::table("_vimov_filter_sm")
            ->select(
                DB::raw("SUM(CASE WHEN fecha_dias_ejecucion >= CURRENT_DATE THEN 1 ELSE 0 END) AS atiempo"),
                DB::raw("SUM(CASE WHEN CURRENT_DATE > fecha_dias_ejecucion THEN 1 ELSE 0 END) AS conrezago")
            )
            ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
            ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
            ->where('dependencia_id', $unidad_id)
            ->whereIn('servicio_id', $ServiciosPrincipales)
            ->where('estatu_id', $ue_id)
            ->groupBy('estatu_id')
            ->first();


    }

    static function getGeoDenuncias($start_date,$end_date,$ServiciosPrincipales){

//        $cacheKey = '_viddss_' . md5($ServiciosPrincipales[0] . $start_date . $end_date);
//        $data = Cache::remember($cacheKey, 60, function () use ($ServiciosPrincipales, $start_date, $end_date) {
//            return DB::table("_viddss")
//                ->select(
//                    'id','latitud','longitud','dependencia','abreviatura',
//                    'nombre_corto_ss','ciudadano','fecha_ingreso','fecha_dias_ejecucion',
//                    'fecha_ultimo_estatus', 'fecha_dias_maximos_ejecucion','ultimo_estatus',
//                    'sue_id','servicio_ultimo_estatus','ue_id','dependencia_id','uuid',
//                    'denuncia','centro_localidad_id','ciudadano_id'
//                )
//                ->whereIn('sue_id', $ServiciosPrincipales)
//                ->where('ambito_dependencia', 2)
//                ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
//                ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
//                ->get();
//        });
        //            ->whereBetween('fecha_ingreso',[$start_date." 00:00:00",$end_date." 23:59:59"])

//        $cacheKey = 'videpdenservestatus_' . md5($ServiciosPrincipales[0] . $start_date . $end_date); // Genera una clave de caché única
//        $data = Cache::remember($cacheKey, 60, function () use ($ServiciosPrincipales, $start_date, $end_date) {
//            return DB::table("_videpdenservestatus")
//                ->where('ambito_dependencia', 2)
//                ->whereIn('servicio_id', $ServiciosPrincipales)
//                ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
//                ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
//                ->get();
//        });

        $cacheKey = '_vimov_filter_sm' . md5($ServiciosPrincipales[0] . $start_date . $end_date); // Genera una clave de caché única
        $data = Cache::remember($cacheKey, 60, function () use ($ServiciosPrincipales, $start_date, $end_date) {
            return DB::table("_vimov_filter_sm")
                ->select(
                    'id','denuncia_id','descripcion','fecha_dias_ejecucion','fecha_dias_maximos_ejecucion',
                    'fecha_ingreso', 'fecha_ultimo_estatus', 'dependencia_id', 'dependencia', 'abreviatura',
                    'ue_id', 'sue_id', 'nombre_corto_ss', 'ciudadano', 'centro_localidad_id', 'latitud','longitud',
                    'estatus','fecha_ultimo_estatus','fecha_ingreso','fecha_dias_ejecucion', 'fecha_dias_maximos_ejecucion',
                    'uuid', 'servicio_id', 'servicio'
                )
                ->whereIn('servicio_id', $ServiciosPrincipales)
                ->where('fecha_ingreso', '>=', $start_date." 00:00:00")
                ->where('fecha_ingreso', '<=', $end_date." 23:59:59")
                ->get();
        });



        return $data;
    }



}
