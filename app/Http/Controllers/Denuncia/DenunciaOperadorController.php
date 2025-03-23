<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Http\Requests\DenunciaCiudadana\DenunciaCiudadanaRequest;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Operador;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Expr\AssignOp\Concat;

class DenunciaOperadorController extends Controller{

    protected $tableName = "Asignación de Solicitudes";
    protected $msg = "";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index($operador_id, Request $request)
    {
        ini_set('max_execution_time', 300);

//        dd($operador_id);

        if ( (int) $operador_id > 0) {
            $items = Denuncia_Operador::where('operador_id', $operador_id)
                ->orderBy('id')
                ->get();
        }else{
            $items = [];
        }

        $request->session()->put('items', $items);

        $operadores = User::whereHas('roles', function ($q) {
                        $q->where('name', 'OPERADOR');
                    })
                    ->orderBy('ap_paterno')
                    ->orderBy('ap_materno')
                    ->orderBy('nombre')
                    ->get(['id', 'ap_paterno', 'ap_materno', 'nombre'])
                    ->mapWithKeys(function ($user) {
                        $apPaterno = strtoupper(trim($user->ap_paterno ?? ''));
                        $apMaterno = strtoupper(trim($user->ap_materno ?? ''));
                        $nombres   = strtoupper(trim($user->nombre ?? ''));

                        $apellidos = trim("{$apPaterno} {$apMaterno}");

                        $fullName = $apellidos ? "{$apellidos}, {$nombres}" : $nombres;

                        return [$user->id => $fullName];
                    });

        $user = Auth::User();

        return view('SIAC.denuncia.denuncia_operador.denuncia_operador_list',
            [
                'items'                           => $items,
                'titulo_catalogo'                 => "Solicitudes",
                'titulo_header'                   => 'Listado de Solicitudes asignadas a los Operadores',
                'user'                            => $user,
                'operadores'                      => $operadores,
                'showListDenuciasOperator'        => 'denuncia_operador_list',
//                'searchInListDenuncia'            => 'listDenunciasCiudadanas',
                'newWindow'                       => true,
                'tableName'                       => $this->tableName,
//                'showEdit'                        => 'editDenunciaCiudadana',
//                'showProcess1'                    => 'showDataListDenunciaExcel1A',
//                'newItem'                         => 'newDenunciaCiudadana',
//                'removeItem'                      => 'removeDenunciaCiudadana',
//                'respuestasDenunciaCiudadanaItem' => 'listRespuestasCiudadanas',
//                'imagenesDenunciaItem'            => 'listImagenes',
//                'searchAdressDenuncia'            => 'listDenuncias',
//                'showModalSearchDenuncia'         => 'showModalSearchDenuncia',
//                'findDataInDenuncia'              =>'findDataInDenuncia',
//                'imprimirDenuncia'                => "imprimirDenuncia/",
//                'showEditDenunciaDependenciaServicio'=>'listDenunciaDependenciaServicio',
            ]
        );
    }

    public function getDenunciaAmbitoAjaxFromId(Request $request){
        $id = $request->denuncia_id;
        $denuncia = _viDDSs::find($id);

        if ($denuncia === null) {
            return response()->json(['mensaje' => 'Error', 'data' => 'No se encuentra la denuncia', 'status' => '422'], 200);
        }

        if ($denuncia->ambito_dependencia != 2) {
            return response()->json(['mensaje' => 'Error', 'data' => 'No es de Servicios Municipales', 'status' => '422'], 200);
        }

        return response()->json(['mensaje' => 'OK', 'data' => $denuncia, 'status' => '200'], 200);

    }

    public function getSolicitudesAmbitoAjaxFromOperator(Request $request){
        $denuncia_id = $request->denuncia_id;
        $user_id = $request->operador_id;
        $denuncia = Denuncia::find($denuncia_id);
        $operador = User::find($user_id);

        try{
            $de = $operador->solicitudes()->attach($denuncia_id);
        } catch (\Exception $e) {
//            dd($e);
        }


        $sols = [];
        foreach ($operador->solicitudes as $sol) {
            $sols[] = $sol->id;
        };

        $solicitudes_operador = _viDDSs::query()
            ->whereIn('id', $sols)
            ->get();

        return response()->json(['mensaje' => 'OK', 'data' => $solicitudes_operador, 'status' => '200'], 200);

    }

}
