<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Classes\MessageAlertClass;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Localidad;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\DenunciaEstatu;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Role;

class ComunidadUnificarController extends Controller{

    use Authorizable;

    protected $tableName = '';
    protected $lstAsigns = "";
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function indexV2($Id = 0){

        $Id = $Id == 0 ? 1 : $Id;
        $users = User::findOrFail($Id);
        $this->lstAsigns = $users->roles->pluck('name','id');

        $user = Auth::User();
        return view ('SIAC.unificar.comunidad.comunidad_unificar',
            [
                'catalogo_titulo' => 'Unificar comunidades',
                'lstAsigns0'      => $this->lstAsigns,
                'titulo_catalogo' => "",
                'titulo_header'   => '',
                'search_autocomplete' => 'search_autocompleta_comunidad',
                'user'            => $user,
                'users'           => $users,
                'getItems'        => '/getRoleUser/',
                'Id'              => $Id,
                'titleLeft0'      => 'Comunidad',
                'titleAsign0'     => 'Comunidad asignada',
                'urlUnifica'      => 'unificacomunidad',
                'urlRegresa'      => 'asignaRoleList',
                'catalogo_id'     => 0,
            ]
        );

    }

    public function unificacomunidad(Request $request){

        try {
        $data     = $request->all(['origins_id','destino_id']);

        $destino_id = (int)$data['destino_id'];
        $origins_id = $data['origins_id'];

        $Comunidad_Destino = Comunidad::findOrFail($destino_id);

        $registros_eliminados = 0;

        $items_arrays = explode('|',$origins_id);

        foreach($items_arrays AS $i=>$valor) {
            $comunidad_origin_id = (int)$valor;

            if ($comunidad_origin_id > 0) {
                if ($comunidad_origin_id !== $destino_id) {

                    $UbiOrigins = Ubicacion::where('comunidad_id', $comunidad_origin_id)->first();
                    $UbiDestino = Ubicacion::where('comunidad_id', $destino_id)->first();

                    //Buscamos en las tablas involucradas y hacemos los cambios
                    $Colonia = Colonia::where('comunidad_id', $comunidad_origin_id)
                        ->update(['comunidad_id' => $destino_id]);

                    $Ubicacion = Ubicacion::where('comunidad_id', $comunidad_origin_id)
                        ->update(['comunidad_id' => $destino_id, 'comunidad' => $Comunidad_Destino->comunidad]);

                    if ($comunidad_origin_id != null && $UbiOrigins != null ) {
                        $Denuncia = Denuncia::where('ubicacion_id', $UbiOrigins->id)
                            ->update(['comunidad' => $Comunidad_Destino->comunidad, 'ubicacion_id' => $Comunidad_Destino->ubicacion_id]);
                    }

                    if ($UbiOrigins != null){
                        $Comunidad = Comunidad::find($comunidad_origin_id);
                        $Comunidad->forceDelete();
                        $Comunidad_Destino->update(['is_unificadora' => true]);
                    }
                    $registros_eliminados = $registros_eliminados + 1;

                }
            }
        }

        return Response::json(['mensaje' => "/unicomunidad", 'data' => 'OK', 'registros_eliminados' => 'Registros unificados: '.$registros_eliminados,  'status' => '200'], 200);

        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return Response::json(['mensaje' => $Msg->Message(), 'data' => $Msg->Message(), 'status' => '200'], 200);
        }

    }








}
