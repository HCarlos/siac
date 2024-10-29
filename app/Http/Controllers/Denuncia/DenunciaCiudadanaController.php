<?php

namespace App\Http\Controllers\Denuncia;

use App\Http\Controllers\Controller;
use App\Http\Requests\DenunciaCiudadana\DenunciaCiudadanaRequest;
use App\Models\Denuncias\Denuncia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DenunciaCiudadanaController extends Controller{

    protected $tableName = "solicitudes";
    protected $msg = "";

// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //
    protected function index(Request $request)
    {
        ini_set('max_execution_time', 300);
        $filters = $request->only(['search']);
        if (!Auth::user()->isRole('Administrator|SysOp')){
            $filters['ciudadano_id']=Auth::user()->id;
        }
        $items = Denuncia::query()
            ->filterBy($filters)
            ->orderByDesc('id')
            ->paginate();
        $items->appends($filters)->fragment('table');

        $request->session()->put('items', $items);

        $user = Auth::User();

        return view('SIAC.denuncia.denuncia_ciudadana.denuncia_ciudadana_list',
            [
                'items'                           => $items,
                'titulo_catalogo'                 => "Mis Solicitudes",
                'titulo_header'                   => '',
                'user'                            => $user,
                'searchInListDenuncia'            => 'listDenunciasCiudadanas',
                'newWindow'                       => true,
                'tableName'                       => $this->tableName,
                'showEdit'                        => 'editDenunciaCiudadana',
                'showProcess1'                    => 'showDataListDenunciaExcel1A',
                'newItem'                         => 'newDenunciaCiudadana',
                'removeItem'                      => 'removeDenunciaCiudadana',
                'respuestasDenunciaCiudadanaItem' => 'listRespuestasCiudadanas',
                'imagenesDenunciaItem'            => 'listImagenes',
                'searchAdressDenuncia'            => 'listDenuncias',
                'showModalSearchDenuncia'         => 'showModalSearchDenuncia',
                'findDataInDenuncia'              =>'findDataInDenuncia',
                'imprimirDenuncia'                => "imprimirDenuncia/",
                'showEditDenunciaDependenciaServicio'=>'listDenunciaDependenciaServicio',
            ]
        );
    }

    protected function newItem(){
        $Servicios = DB::table("_viservicios")->select('*')->where('is_visible_mobile',true)->orderBy('orden_image_mobile')->get();
        $this->msg    = "";

        return view('SIAC.denuncia.denuncia_ciudadana.denuncia_ciudadana_new',
            [
                'user'            => Auth::user(),
                'editItemTitle'   => 'Nuevo',
                'Servicios'       => $Servicios,
                'postNew'         => 'createDenunciaCiudadana',
                'titulo_catalogo' => "Mis Solicitudes",
                'titulo_header'   => 'Folio Nuevo',
                'exportModel'     => 23,
                'msg'             => $this->msg,
            ]
        );
    }

    // ***************** CREAR NUEVO ++++++++++++++++++++ //
    protected function createItem(DenunciaCiudadanaRequest $request){
        $item = $request->manageDC();
        return Redirect::to('listDenunciasCiudadanas/');
    }


}
