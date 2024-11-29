<?php

namespace App\Http\Controllers\Catalogos\User;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\Dependencia;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class DependenciaController extends Controller{


    protected $tableName = '';
    protected $lstAsigns = "";
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($Id = 0){
        $listEle     = Dependencia::select('id','dependencia as data')
                        ->orderBy('dependencia')
                        ->pluck('data','id');
        $listTarget  = null;
//        $listTarget  = User::all()->sortBy(function($item) {
//            return $item->ap_paterno.' '.$item->ap_materno.' '.$item->nombre;
//        });
        $Id = $Id == 0 ? 1 : $Id;
        $users = User::findOrFail($Id);
        $this->lstAsigns = $users->dependencias->sortBy('dependencia')->pluck('dependencia','id');

        //dd($this->lstAsigns);

        $user = Auth::User();
        return view ('catalogos.asignaciones.dependencias_usuario',
            [
                'catalogo_titulo' => '',
                'listEle0'        => $listEle,
                'listTarget0'     => $listTarget,
                'lstAsigns0'      => $this->lstAsigns,
                'titulo_catalogo' => "Asignación de Unidades Administrativas",
                'titulo_header'   => '',
                'user'            => $user,
                'users'           => $users,
                'getItems'        => '/getDependenciasUser/',
                'Id'              => $Id,
                'titleLeft0'      => "Unidades Administrativas",
                'titleUsuario0'   => "Usuario",
                'titleAsign0'     => "Unidades Administrativas asignadas",
                'urlAsigna'       => "assignDepToUser",
                'urlRegresa'      => "asignaDependenciaList",
                'urlElimina'      => "unAssignDepToUser",
            ]
        );

    }

    public function getItems($Id = 0){
        $Items = User::find($Id);
        ;
        return Response::json(['mensaje' => "OK", 'data' => $Items->dependencias->pluck('dependencia','id'), 'status' => '200'], 200);
    }



    public function asignarDep(Request $request): JsonResponse{

        $data     = $request->all(['Id','names']);

        $Id        = $data['Id'];
        $nameDependencias = $data['names'];

        $user = User::findOrFail($Id);
        $dependencias = explode('|',$nameDependencias);
        foreach($dependencias AS $i=>$valor) {
            if ($dependencias[$i] !== ""){
                $dependencia = Dependencia::where('id', $dependencias[$i])->first();
                $rl = $user->hasDependencia($dependencias[$i]); // Dependencia::where('name',$perm)->count();
                if (!$rl) {
                    $user->dependencias()->attach($dependencia);
                }
            }
        }

        return Response::json(['mensaje' => "/asignaDependenciaList/$Id", 'data' => 'OK', 'status' => '200'], 200);

    }

    public function desasignarDep(Request $request): JsonResponse{

        $data     = $request->all(['Id','names']);

        $Id        = $data['Id'];
        $nameDependencias = $data['names'];

        $user = User::findOrFail($Id);
        $dependencias = explode('|',$nameDependencias);
        foreach($dependencias AS $i=>$valor) {
            if ($dependencias[$i] !== "") {
                $dependencia = Dependencia::where('id', $dependencias[$i])->first();
                $rl = $user->hasDependencia($dependencias[$i]); // Dependencia::where('name',$perm)->count();
                if ($rl) {
                    $user->dependencias()->detach($dependencia);
                }
            }
        }
        return Response::json(['mensaje' => "/asignaDependenciaList/$Id", 'data' => 'OK', 'status' => '200'], 200);
    }

}
