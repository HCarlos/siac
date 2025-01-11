<?php

namespace App\Http\Controllers\Catalogos\User;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Prioridad;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PrioridadesUserController extends Controller{


    protected $tableName = '';
    protected $lstAsigns = "";
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($Id = 0){
        $listEle     = Prioridad::select('id','prioridad as data')
                        ->orderBy('prioridad')
                        ->pluck('data','id');
        $listTarget  = null;
        $Id = $Id == 0 ? 1 : $Id;
        $users = User::findOrFail($Id);
        $this->lstAsigns = $users->prioridades->sortBy('prioridad')->pluck('prioridad','id');

//        dd($this->lstAsigns);

        $user = Auth::User();
        return view ('catalogos.asignaciones.prioridades_usuario',
            [
                'catalogo_titulo' => '',
                'listEle0'        => $listEle,
                'listTarget0'     => $listTarget,
                'lstAsigns0'      => $this->lstAsigns,
                'titulo_catalogo' => "Asignación de Prioridades",
                'titulo_header'   => '',
                'user'            => $user,
                'users'           => $users,
                'getItems'        => '/getPrioridadesUser/',
                'Id'              => $Id,
                'titleLeft0'      => "Prioridades",
                'titleUsuario0'   => "Usuario",
                'titleAsign0'     => "Prioridades asignadas",
                'urlAsigna'       => "assignPrioridadToUser",
                'urlRegresa'      => "asignaPrioridadesList",
                'urlElimina'      => "unAssignPrioridadToUser",
            ]
        );

    }

    public function getItems($Id = 0){
        $Items = User::find($Id);
        ;
        return Response::json(['mensaje' => "OK", 'data' => $Items->prioridades->pluck('prioridad','id'), 'status' => '200'], 200);
    }



    public function asignarPrioridad(Request $request): JsonResponse{

        $data  = $request->all(['Id','names']);

        $Id    = $data['Id'];
        $names = $data['names'];

        $user = User::findOrFail($Id);
        $prioridad = explode('|',$names);
        foreach($prioridad AS $i=>$valor) {
//            if ($prioridad[$i] !== ""){
            if (($prioridad[$i] !== "") && ($prioridad[$i] !== null)){
                $Prioridad = Prioridad::where('id', $prioridad[$i])->first();
                $rl = $user->hasPrioridades($prioridad[$i]);
                if (!$rl) {
                    $user->prioridades()->attach($Prioridad);
                }
            }
        }

        return Response::json(['mensaje' => "/asignaPrioridadesList/$Id", 'data' => 'OK', 'status' => '200'], 200);

    }

    public function desasignarPrioridad(Request $request): JsonResponse{

        $data  = $request->all(['Id','names']);

        $Id    = $data['Id'];
        $names = $data['names'];

        $user = User::findOrFail($Id);
        $prioridad = explode('|',$names);
        foreach($prioridad AS $i=>$valor) {
            if ( ($prioridad[$i] !== "") && ($prioridad[$i] !== null) ){
                $Prioridad = Prioridad::where('id', $prioridad[$i])->first();
                $rl = $user->hasPrioridades($prioridad[$i]);
                if ($rl) {
                    $user->prioridades()->detach($Prioridad);
                }
            }
        }
        return Response::json(['mensaje' => "/asignaPrioridadesList/$Id", 'data' => 'OK', 'status' => '200'], 200);
    }





}
