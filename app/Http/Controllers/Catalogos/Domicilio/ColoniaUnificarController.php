<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Classes\MessageAlertClass;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Denuncias\Denuncia;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ColoniaUnificarController extends Controller{


    use Authorizable;

    protected $tableName = '';
    protected $lstAsigns = "";
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function indexV2($Id = 0){

        $Id = $Id == 0 ? 1 : $Id;

        $user = Auth::User();
        return view ('SIAC.unificar.colonia.colonia_unificar',
            [
                'catalogo_titulo' => 'Unificar colonias',
                'titulo_catalogo' => "",
                'titulo_header'   => '',
                'user'            => $user,
                'titleLeft0'      => 'Colonia',
                'titleAsign0'     => 'Colonia asignada',
                'urlUnifica'      => 'unificacolonia',
                'catalogo_id'     => 1,
            ]
        );

    }

    public function unificacolonia(Request $request){

        try {

            $data     = $request->all(['origins_id','destino_id']);

            $destino_id = intval($data['destino_id']);
            $origins_id = $data['origins_id'];

            $Colonia_Destino = Colonia::findOrFail($destino_id);

            $registros_eliminados = 0;

            $items_arrays = explode('|',$origins_id);

            foreach($items_arrays AS $i=>$valor) {
                $colonia_origin_id = intval($items_arrays[$i]); //intval($items_arrays[$i]);

                if ($colonia_origin_id > 0) {
                    if ($colonia_origin_id !== $destino_id) {

                        $UbiOrigins = Ubicacion::where('colonia_id', $colonia_origin_id)->first();
                        $UbiDestino = Ubicacion::where('colonia_id', $destino_id)->first();

                        //Buscamos en las tablas involucradas y hacemos los cambios

                        $Ubicacion = Ubicacion::where('colonia_id', $colonia_origin_id)
                            ->update(['colonia_id' => $destino_id, 'colonia' => $Colonia_Destino->colonia]);

                        if ($colonia_origin_id != null && $UbiOrigins != null ) {
                            $Denuncia = Denuncia::where('ubicacion_id', $UbiOrigins->id)
                                ->update(['colonia' => $Colonia_Destino->colonia, 'ubicacion_id' => $Colonia_Destino->ubicacion_id]);
                        }

                        if ($UbiOrigins != null){
                            $Comunidad = Colonia::find($colonia_origin_id);
                            $Comunidad->forceDelete();
                            $Colonia_Destino->update(['is_unificadora' => true]);
                        }
                        $registros_eliminados = $registros_eliminados + 1;

                    }
                }
            }

            return Response::json(['mensaje' => "/unicolonia", 'data' => 'OK', 'registros_eliminados' => 'Registros unificados: '.$registros_eliminados,  'status' => '200'], 200);

        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return Response::json(['mensaje' => $Msg->Message(), 'data' => $Msg->Message(), 'status' => '200'], 200);
        }

    }


}
