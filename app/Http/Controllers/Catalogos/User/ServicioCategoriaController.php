<?php

namespace App\Http\Controllers\Catalogos\User;

use App\Http\Controllers\Controller;
use App\Models\Catalogos\ServicioCategoria;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RequServCat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ServicioCategoriaController extends Controller{



    protected $tableName = '';
    protected $lstAsigns = "";
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($Id = 0){
        $listEle     = ServicioCategoria::select('id','categoria_servicios as data')
            ->orderBy('categoria_servicios')
            ->pluck('data','id');
        $listTarget  = null;
        $Id = $Id == 0 ? 1 : $Id;
        $users = User::findOrFail($Id);
        $this->lstAsigns = $users->servicioscategorias->sortBy('categoria_servicios')->pluck('categoria_servicios','id');

//        dd($this->lstAsigns);

        $user = Auth::User();
        return view ('catalogos.asignaciones.servicioscategorias_usuario',
            [
                'catalogo_titulo' => '',
                'listEle0'        => $listEle,
                'listTarget0'     => $listTarget,
                'lstAsigns0'      => $this->lstAsigns,
                'titulo_catalogo' => "Asignación de Categoria de Servicios",
                'titulo_header'   => '',
                'user'            => $user,
                'users'           => $users,
                'getItems'        => '/getServCatUser/',
                'Id'              => $Id,
                'titleLeft0'      => "Categorías de Servicios",
                'titleUsuario0'   => "Usuario",
                'titleAsign0'     => "Categorías asignados",
                'urlAsigna'       => "assignServCatToUser",
                'urlRegresa'      => "asignaServCatList",
                'urlElimina'      => "unAssignServCatToUser",
            ]
        );

    }

    public function getItems($Id = 0){
        $Items = User::find($Id);
        ;
        return Response::json(['mensaje' => "OK", 'data' => $Items->servicioscategorias->pluck('categoria_servicios','id'), 'status' => '200'], 200);
    }



    public function asignarServCat(Request $request): JsonResponse{

        $data     = $request->all(['Id','names']);

        $Id        = $data['Id'];
        $nameServicioCategorias = $data['names'];

        $user = User::findOrFail($Id);
        $ServicioCategorias = explode('|',$nameServicioCategorias);
        foreach($ServicioCategorias AS $i=>$valor) {
            if ($ServicioCategorias[$i] !== ""){
                $ServicioCategoria = ServicioCategoria::where('id', $ServicioCategorias[$i])->first();
                $rl = $user->hasServiciosCategorias($ServicioCategorias[$i]);
                if (!$rl) {
                    $user->servicioscategorias()->attach($ServicioCategoria);
                }
            }
        }

        return Response::json(['mensaje' => "/asignaServCatList/$Id", 'data' => 'OK', 'status' => '200'], 200);

    }

    public function desasignarServCat(Request $request): JsonResponse{

        $data     = $request->all(['Id','names']);

        $Id        = $data['Id'];
        $nameServicioCategorias = $data['names'];

        $user = User::findOrFail($Id);
        $ServicioCategorias = explode('|',$nameServicioCategorias);
        foreach($ServicioCategorias AS $i=>$valor) {
            if ($ServicioCategorias[$i] !== "") {
                $ServicioCategoria = ServicioCategoria::where('id', $ServicioCategorias[$i])->first();
                $rl = $user->hasServiciosCategorias($ServicioCategorias[$i]);
                if ($rl) {
                    $user->servicioscategorias()->detach($ServicioCategoria);
                }
            }
        }
        return Response::json(['mensaje' => "/asignaServCatList/$Id", 'data' => 'OK', 'status' => '200'], 200);
    }





}
