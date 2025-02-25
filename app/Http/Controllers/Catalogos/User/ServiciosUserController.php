<?php

namespace App\Http\Controllers\Catalogos\User;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\_viServicios;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ServiciosUserController extends Controller{


    protected $tableName = '';
    protected $lstAsigns = "";
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($Id = 0){
        $listEle     = _viServicios::select('id','servicio as data')
                        ->where('ambito_dependencia',2)
                        ->orderBy('servicio')
                        ->pluck('data','id');
        $listTarget  = null;
        $Id = $Id == 0 ? 1 : $Id;
        $users = User::findOrFail($Id);
        $this->lstAsigns = $users->servicios->sortBy('servicio')->pluck('servicio','id');

//        dd($this->lstAsigns);

        $user = Auth::User();
        return view ('catalogos.asignaciones.servicios_usuario',
            [
                'catalogo_titulo' => '',
                'listEle0'        => $listEle,
                'listTarget0'     => $listTarget,
                'lstAsigns0'      => $this->lstAsigns,
                'titulo_catalogo' => "Asignación de Servicios",
                'titulo_header'   => '',
                'user'            => $user,
                'users'           => $users,
                'getItems'        => '/getServiciosUser/',
                'Id'              => $Id,
                'titleLeft0'      => "Servicios",
                'titleUsuario0'   => "Usuario",
                'titleAsign0'     => "Servicios asignadas",
                'urlAsigna'       => "assignServicioToUser",
                'urlRegresa'      => "asignaServiciosList",
                'urlElimina'      => "unAssignServicioToUser",
            ]
        );

    }

    public function getItems($Id = 0){
        $Items = User::find($Id);
        ;
        return Response::json(['mensaje' => "OK", 'data' => $Items->servicios->pluck('servicio','id'), 'status' => '200'], 200);
    }



    public function asignarServicio(Request $request): JsonResponse{

        $data  = $request->all(['Id','names']);

        $Id    = $data['Id'];
        $names = $data['names'];

        $user = User::findOrFail($Id);
        $servicio = explode('|',$names);
        foreach($servicio AS $i=>$valor) {
//            if ($servicio[$i] !== ""){
            if (($servicio[$i] !== "") && ($servicio[$i] !== null)){
                $Servicio = Servicio::where('id', $servicio[$i])->first();
                $rl = $user->hasServicios($servicio[$i]);
                if (!$rl) {
                    $user->servicios()->attach($Servicio);
                }
            }
        }

        return Response::json(['mensaje' => "/asignaServiciosList/$Id", 'data' => 'OK', 'status' => '200'], 200);

    }

    public function desasignarServicio(Request $request): JsonResponse{

        $data  = $request->all(['Id','names']);

        $Id    = $data['Id'];
        $names = $data['names'];

        $user = User::findOrFail($Id);
        $servicio = explode('|',$names);
        foreach($servicio AS $i=>$valor) {
            if ( ($servicio[$i] !== "") && ($servicio[$i] !== null) ){
                $Servicio = Servicio::where('id', $servicio[$i])->first();
                $rl = $user->hasServicios($servicio[$i]);
                if ($rl) {
                    $user->servicios()->detach($Servicio);
                }
            }
        }
        return Response::json(['mensaje' => "/asignaServiciosList/$Id", 'data' => 'OK', 'status' => '200'], 200);
    }





}
