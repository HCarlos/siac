<?php

namespace App\Http\Controllers\Catalogos\User;

use App\User;
use Illuminate\Foundation\Auth\Access\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use Authorizable;

    protected $tableName = '';
    protected $lstAsigns = "";
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($Id = 0){
        $listEle     = Role::select('id','name as data')->pluck('data','id');
        $listTarget  = User::all()->sortBy(function($item) {
            return $item->ap_paterno.' '.$item->ap_materno.' '.$item->nombre;
        });
//        $listTarget  = User::select('id','username','ap_paterno','ap_materno','nombre')->orderBy('ap_paterno','asc')->get();
        $Id = $Id == 0 ? 1 : $Id;
        $users = User::findOrFail($Id);
        $this->lstAsigns = $users->roles->pluck('name','id');

        $user = Auth::User();
        return view ('catalogos.asignaciones.roles_usuario',
            [
                'catalogo_titulo' => '',
                'listEle0'        => $listEle,
                'listTarget0'     => $listTarget,
                'lstAsigns0'      => $this->lstAsigns,
                'titulo_catalogo' => "Asignación de Roles",
                'titulo_header'   => '',
                'user'            => $user,
                'Id'              => $Id,
                'titleLeft0'      => "Roles",
                'titleUsuario0'   => "Usuario",
                'titleAsign0'     => "Roles asignados",
                'urlAsigna'       => "assignRoleToUser",
                'urlRegresa'      => "asignaRoleList",
                'urlElimina'      => "unAssignRoleToUser",
            ]
        );

    }


    public function indexV2($Id = 0){
        $listEle     = Role::select('id','name as data')->pluck('data','id');
        $listTarget  = null;
//        $listTarget  = User::select('id','username','ap_paterno','ap_materno','nombre')->orderBy('ap_paterno','asc')->get();
        $Id = $Id == 0 ? 1 : $Id;
        $users = User::findOrFail($Id);
        $this->lstAsigns = $users->roles->pluck('name','id');

        $user = Auth::User();
        return view ('catalogos.asignaciones.roles_usuario',
            [
                'catalogo_titulo' => '',
                'listEle0'        => $listEle,
                'listTarget0'     => $listTarget,
                'lstAsigns0'      => $this->lstAsigns,
                'titulo_catalogo' => "Asignación de Roles",
                'titulo_header'   => '',
                'user'            => $user,
                'users'           => $users,
                'getItems'        => '/getRoleUser/',
                'Id'              => $Id,
                'titleLeft0'      => "Roles",
                'titleUsuario0'   => "Usuario",
                'titleAsign0'     => "Roles asignados",
                'urlAsigna'       => "assignRoleToUser",
                'urlRegresa'      => "asignaRoleList",
                'urlElimina'      => "unAssignRoleToUser",
            ]
        );

    }

    public function getItems($Id = 0){
        $Items = User::find($Id);
        ;
        return Response::json(['mensaje' => "OK", 'data' => $Items->roles->pluck('name','id'), 'status' => '200'], 200);

    }


    public function asignar(Request $request){

        $data     = $request->all(['Id','names']);

        $Id        = $data['Id'];
        $nameRoles = $data['names'];


        $user = User::findOrFail($Id);
//        dd($user->username);
        $roles = explode('|',$nameRoles);
        foreach($roles AS $i=>$valor) {
            if ($roles[$i] !== ""){
                $role = Role::where('id', $roles[$i])->first();
                $rl = $user->hasRole($roles[$i]); // Role::where('name',$perm)->count();
                if (!$rl) {
                    $user->roles()->attach($role);
                    if ($roles[$i] === 'administrator'){
                        $user->admin = true;
                        $user->save();
                    }
                }
            }
        }
        return Response::json(['mensaje' => "/asignaRoleList/$Id", 'data' => 'OK', 'status' => '200'], 200);

        //return redirect()->route("asignaRoleList",["Id"=>$Id]);

    }

    public function desasignar(Request $request){

        $data     = $request->all(['Id','names']);
        $Id        = $data['Id'];
        $nameRoles = $data['names'];

        //dd($Id);

        $user = User::findOrFail($Id);
        $roles = explode('|',$nameRoles);
        foreach($roles AS $i=>$valor) {
            if ($roles[$i] !== "") {
                $role = Role::where('id', $roles[$i])->first();
                $user->removeRole($role);
                if ($roles[$i] === 'administrator'){
                    $user->admin = false;
                    $user->save();
                }

            }
        }
        return Response::json(['mensaje' => "/asignaRoleList/$Id", 'data' => 'OK', 'status' => '200'], 200);
    }

}
