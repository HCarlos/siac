<?php

namespace App\Http\Controllers\Catalogos\User;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\_viServicios;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class OperadoresSupervisorController extends Controller{


    protected $tableName = '';
    protected $lstAsigns = "";
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($Id = 0){
//        $listEle     = _viServicios::select('id', DB::raw("CONCAT(servicio,' - ',abreviatura_dependencia) AS data") )
//                        ->whereIn('ambito_dependencia',[1,2])
//                        ->orderBy('servicio')
//                        ->pluck('data','id');

        $listEle = User::query()
            ->whereHas('roles', fn ($q) => $q->where('name', 'OPERADOR'))
            ->get()
            ->pluck('full_name', 'id'); // aquí sí funciona porque ya está en memoria


        $listTarget  = null;
//        $Id = $Id == 0 ? 1 : $Id;
//        $users = User::findOrFail($Id);
//        $this->lstAsigns = $users->operadores->sortBy('full_name')->pluck('full_name','id');

        $Id = $Id == 0 ? 1 : $Id;
        $users = User::with('supervisores')->findOrFail($Id);
        $lstSuper0 = User::with('supervisores')->findOrFail($Id);

        $supervisor = User::findOrFail($Id);

        $this->lstAsigns = $supervisor->operadores()
            ->orderBy('ap_paterno', 'asc')
            ->orderBy('ap_materno', 'asc')
            ->orderBy('nombre', 'asc')
            ->get()
            ->pluck('full_name', 'id');

//        dd($this->lstAsigns);

        $user = Auth::User();
        return view ('catalogos.asignaciones.operadores_supervisor',
            [
                'catalogo_titulo' => '',
                'listEle0'        => $listEle,
                'lstSuper0'       => $lstSuper0,
                'listTarget0'     => $listTarget,
                'lstAsigns0'      => $this->lstAsigns,
                'titulo_catalogo' => "Asignación de Operadores",
                'titulo_header'   => '',
                'user'            => $user,
                'users'           => $users,
                'getItems'        => '/getSupervisoresUser/',
                'Id'              => $Id,
                'titleLeft0'      => "Operadores",
                'titleUsuario0'   => "Supervisor",
                'titleAsign0'     => "Operadores asignadas",
                'urlAsigna'       => "assignSupervisorToUser",
                'urlRegresa'      => "asignaSupervisoresList",
                'urlElimina'      => "unAssignSupervisorToUser",
            ]
        );

    }

    public function getItems($Id = 0){
        $user = User::find($Id);
        $Items = $user->operadores->pluck('full_name','id');
        if ( ! $user->hasRole('SUPERVISOR')) {
            $Items = ["full_name"=>"No es Supervisor"];
        }
        return Response::json(['mensaje' => "OK", 'data' => $Items, 'status' => '200'], 200);
    }



    public function asignarSupervisor(Request $request): JsonResponse{

        $data  = $request->all(['Id','names']);


        $Id    = $data['Id'];
        $names = $data['names'];

        $user = User::findOrFail($Id);
        if ( ! $user->hasRole('SUPERVISOR')) {
            return Response::json(['mensaje' => "/asignaSupervisoresList/$Id", 'data' => 'OK', 'status' => '200'], 200);
        }

        $operadores = explode('|',$names);
        foreach($operadores AS $i=>$valor) {
            if (($operadores[$i] !== "") && ($operadores[$i] !== null)){
                $operador = User::find($operadores[$i]);
                $rl = $user->hasOperadores($operadores[$i]);
                if (!$rl) {
                    $user->operadores()->attach($operador);
                }
            }
        }

        return Response::json(['mensaje' => "/asignaSupervisoresList/$Id", 'data' => 'OK', 'status' => '200'], 200);

    }

    public function desasignarSupervisor(Request $request): JsonResponse{

        $data  = $request->all(['Id','names']);

        $Id    = $data['Id'];
        $names = $data['names'];

        $user = User::findOrFail($Id);
        $operadores = explode('|',$names);
        foreach($operadores AS $i=>$valor) {
            if ( ($operadores[$i] !== "") && ($operadores[$i] !== null) ){
                $operador = User::find($operadores[$i]);
                $rl = $user->hasOperadores($operadores[$i]);
                if ($rl) {
                    $user->operadores()->detach($operador);
                }
            }
        }
        return Response::json(['mensaje' => "/asignaSupervisoresList/$Id", 'data' => 'OK', 'status' => '200'], 200);
    }





}
