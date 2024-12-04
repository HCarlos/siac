<?php

namespace App\Http\Controllers\Catalogos\User;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Estatu;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class EstatusController extends Controller{


    protected $tableName = '';
    protected $lstAsigns = "";
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($Id = 0){
        $listEle     = Estatu::select('id','estatus as data')
                        ->orderBy('estatus')
                        ->pluck('data','id');
        $listTarget  = null;
        $Id = $Id == 0 ? 1 : $Id;
        $users = User::findOrFail($Id);
        $this->lstAsigns = $users->estatus->sortBy('estatus')->pluck('estatus','id');

//        dd($this->lstAsigns);

        $user = Auth::User();
        return view ('catalogos.asignaciones.estatus_usuario',
            [
                'catalogo_titulo' => '',
                'listEle0'        => $listEle,
                'listTarget0'     => $listTarget,
                'lstAsigns0'      => $this->lstAsigns,
                'titulo_catalogo' => "Asignación de Estatus",
                'titulo_header'   => '',
                'user'            => $user,
                'users'           => $users,
                'getItems'        => '/getEstatusUser/',
                'Id'              => $Id,
                'titleLeft0'      => "Estatus",
                'titleUsuario0'   => "Usuario",
                'titleAsign0'     => "Estatus asignados",
                'urlAsigna'       => "assignEstToUser",
                'urlRegresa'      => "asignaEstatusList",
                'urlElimina'      => "unAssignEstToUser",
            ]
        );

    }

    public function getItems($Id = 0){
        $Items = User::find($Id);
        ;
        return Response::json(['mensaje' => "OK", 'data' => $Items->estatus->pluck('estatus','id'), 'status' => '200'], 200);
    }


    public function asignarEst(Request $request): JsonResponse{

        $data     = $request->all(['Id','names']);

        $Id        = $data['Id'];
        $nameEstatus = $data['names'];

        $user = User::findOrFail($Id);
        $Estatus = explode('|',$nameEstatus);
        foreach($Estatus AS $i=>$valor) {
            if ($Estatus[$i] !== ""){
                $Estatu = Estatu::where('id', $Estatus[$i])->first();
                $rl = $user->hasEstatus($Estatus[$i]);
                if (!$rl) {
                    $user->estatus()->attach($Estatu);
                }
            }
        }

        return Response::json(['mensaje' => "/asignaEstatusList/$Id", 'data' => 'OK', 'status' => '200'], 200);

    }

    public function desasignarEst(Request $request): JsonResponse{

        $data     = $request->all(['Id','names']);

        $Id        = $data['Id'];
        $nameEstatus = $data['names'];

        $user = User::findOrFail($Id);
        $Estatus = explode('|',$nameEstatus);
        foreach($Estatus AS $i=>$valor) {
            if ($Estatus[$i] !== "") {
                $Estatu = Estatu::where('id', $Estatus[$i])->first();
                $rl = $user->hasEstatus($Estatus[$i]);
                if ($rl) {
                    $user->estatus()->detach($Estatu);
                }
            }
        }
        return Response::json(['mensaje' => "/asignaEstatusList/$Id", 'data' => 'OK', 'status' => '200'], 200);
    }





}
