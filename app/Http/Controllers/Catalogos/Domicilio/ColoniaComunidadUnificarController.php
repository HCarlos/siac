<?php

namespace App\Http\Controllers\Catalogos\Domicilio;

use App\Classes\MessageAlertClass;
use App\Http\Controllers\Controller;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Denuncias\Denuncia;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ColoniaComunidadUnificarController extends Controller{



    use Authorizable;

    protected $tableName = '';
    protected $lstAsigns = "";
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function unicolcom($Id = 0){

        $Id = $Id == 0 ? 1 : $Id;

        $user = Auth::User();
        return view ('SIAC.unificar.colonia_a_comunidad.colonias_a_comunidad_unificar',
            [
                'catalogo_titulo' => 'Asignar colonias',
                'titulo_catalogo' => "",
                'titulo_header'   => '',
                'user'            => $user,
                'titleLeft0'      => 'Colonia',
                'titleAsign0'     => 'Colonia asignada',
                'urlUnifica'      => 'unificacoloniaacomunidad',
                'catalogo_id'     => 2,
            ]
        );

    }

    public function unificacoloniaacomunidad(Request $request){

        try {

            $data     = $request->all(['origins_id','destino_id']);

//            dd($data);

            $destino_id = (int)$data['destino_id'];
            $origins_id = $data['origins_id'];

            $ComDes = Comunidad::findOrFail($destino_id);

            $registros_eliminados = 0;

            $items_arrays = explode('|',$origins_id);

            foreach($items_arrays AS $i=>$valor) {
                $colonia_origin_id = (int)$valor; //intval($items_arrays[$i]);
                if ($colonia_origin_id > 0) {

                        $Colonia = Colonia::where('id', $colonia_origin_id )
                            ->update(['comunidad_id' => $ComDes->id]);


                        $Ubicaciones = Ubicacion::where('colonia_id', $colonia_origin_id)
                            ->update(['comunidad_id' => $ComDes->id,'comunidad' => $ComDes->comunidad]);

                    $Ubis = Ubicacion::query()->where('colonia_id', $colonia_origin_id)->get();

                    //                    dd ( $Ubi ) ;

                    foreach ($Ubis as $Ubi){
                        $Denuncias = Denuncia::where('ubicacion_id', $Ubi->id)
                            ->update(['comunidad' => $ComDes->comunidad]);
                    }

                    $registros_eliminados++;
                }
            }

            return Response::json(['mensaje' => "/unicolonia", 'data' => 'OK', 'registros_eliminados' => 'Registros unificados: '.$registros_eliminados,  'status' => '200'], 200);

        }catch (QueryException $e){
//            $Msg = new MessageAlertClass();
            return Response::json(['mensaje' => $e->errorInfo, 'data' => null, 'status' => '200'], 200);
        }

    }



}
