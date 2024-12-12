<?php

namespace App\Http\Controllers\Catalogos\User;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Origen;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class OrigenesUserController extends Controller{


    protected $tableName = '';
    protected $lstAsigns = "";
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($Id = 0){
        $listEle     = Origen::select('id','origen as data')
                        ->orderBy('origen')
                        ->pluck('data','id');
        $listTarget  = null;
        $Id = $Id == 0 ? 1 : $Id;
        $users = User::findOrFail($Id);
        $this->lstAsigns = $users->origenes->sortBy('origen')->pluck('origen','id');

//        dd($this->lstAsigns);

        $user = Auth::User();
        return view ('catalogos.asignaciones.origenes_usuario',
            [
                'catalogo_titulo' => '',
                'listEle0'        => $listEle,
                'listTarget0'     => $listTarget,
                'lstAsigns0'      => $this->lstAsigns,
                'titulo_catalogo' => "Asignación de Fuentes de Captación",
                'titulo_header'   => '',
                'user'            => $user,
                'users'           => $users,
                'getItems'        => '/getOrigenesUser/',
                'Id'              => $Id,
                'titleLeft0'      => "Fuente de Captación",
                'titleUsuario0'   => "Usuario",
                'titleAsign0'     => "Fuentes asignadas",
                'urlAsigna'       => "assignOrigenToUser",
                'urlRegresa'      => "asignaOrigenesList",
                'urlElimina'      => "unAssignOrigenToUser",
            ]
        );

    }

    public function getItems($Id = 0){
        $Items = User::find($Id);
        ;
        return Response::json(['mensaje' => "OK", 'data' => $Items->origenes->pluck('origen','id'), 'status' => '200'], 200);
    }



    public function asignarOrigen(Request $requOrigen): JsonResponse{

        $data  = $requOrigen->all(['Id','names']);

        $Id    = $data['Id'];
        $names = $data['names'];

        $user = User::findOrFail($Id);
        $origen = explode('|',$names);
        foreach($origen AS $i=>$valor) {
            if ($origen[$i] !== ""){
                $Origen = Origen::where('id', $origen[$i])->first();
                $rl = $user->hasOrigenes($origen[$i]); ;
                if (!$rl) {
                    $user->origenes()->attach($Origen);
                }
            }
        }

        return Response::json(['mensaje' => "/asignaOrigenesList/$Id", 'data' => 'OK', 'status' => '200'], 200);

    }

    public function desasignarOrigen(Request $request): JsonResponse{

        $data  = $request->all(['Id','names']);

        $Id    = $data['Id'];
        $names = $data['names'];

        $user = User::findOrFail($Id);
        $origen = explode('|',$names);
        foreach($origen AS $i=>$valor) {
            if ($origen[$i] !== "") {
                $Origen = Origen::where('id', $origen[$i])->first();
                $rl = $user->hasOrigenes($origen[$i]);
                if ($rl) {
                    $user->origenes()->detach($Origen);
                }
            }
        }
        return Response::json(['mensaje' => "/asignaOrigenesList/$Id", 'data' => 'OK', 'status' => '200'], 200);
    }





}
