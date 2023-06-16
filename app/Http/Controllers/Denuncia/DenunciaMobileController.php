<?php

namespace App\Http\Controllers\Denuncia;

use App\Events\IUQDenunciaEvent;
use App\Http\Controllers\Controller;
use App\Models\Denuncias\Denuncia;
use App\Models\Mobiles\Denunciamobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class DenunciaMobileController extends Controller{

    protected $tableName = "denunciamobile";
    protected $paginationTheme = 'bootstrap';
    protected $msg = "";
    protected $max_item_for_query = 100;

    // ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //

    /**
     * @param string $tableName
     */

    public function __construct(){
        $this->middleware('auth');
    }

    protected function index(Request $request){
        ini_set('max_execution_time', 300);

        $filters['filterdata'] = $request->only(['search']);
        $IsEnlace = Session::get('IsEnlace');
        if($IsEnlace) {
            $DependenciaIdArray = Session::get('DependenciaIdArray');
            $items = Denunciamobile::query()
                ->whereHas('Servicio', function ($q) use ($DependenciaIdArray){
                    return $q->whereIn('dependencia_id',$DependenciaIdArray);
                })
                ->orderByDesc('id')
                ->paginate(1000);
        }else{
            $items = Denunciamobile::query()
                ->orderByDesc('id')
                ->paginate(1000);
        }
        $items->appends($filters)->fragment('table');
        $search = $request->only(['search']);

        $request->session()->put('items', $items);

        session(['msg' => '']);

        $user = Auth::User();

        return view('SIAC.denuncia.denuncia.denuncia_mobile_list',
            [
                'items'                   => $items,
                'titulo_catalogo'         => "Solicitudes de Servicios vía Mobile",
                'titulo_header'           => '',
                'user'                    => $user,
                'searchInListDenuncia'    => 'listDenunciasMobile',
                'newWindow'               => true,
                'tableName'               => $this->tableName,
                'removeItem'              => 'removeDenunciaMobile',
            ]
        );

    }


    protected function removeDenunciaMobile($id = 0){
        $trigger_type = 2;

//        $DenMob = Denunciamobile::findOrFail($id);
//        $Den = Denuncia::findOrFail($$DenMob->denuncia_id);

        $item = Denunciamobile::withTrashed()->findOrFail($id);
        if (isset($item)) {
            if (!$item->trashed()) {
                $item->forceDelete();
            } else {
                $item->forceDelete();
            }
            event(new IUQDenunciaEvent($item->id,Auth::user()->id,$trigger_type));
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        } else {
            return Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
        }
    }



}
