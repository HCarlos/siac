<?php

namespace App\Http\Controllers\Denuncia\Imagene;

use App\Classes\MessageAlertClass;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Requests\Denuncia\Imagene\ImagenAImagenRequest;
use App\Http\Requests\Denuncia\Imagene\ImageneRequest;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Imagene;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ImageneController extends Controller{


//************************************************************************************
//************             R   E   S   P   U   E   S   T   A   S                    ***
//***************************************************************+++++++++++++++++++**

    protected $tableName = "imagenes";
    protected $disk = 'denuncia';
    protected $F;

    // Obtiene el Listado de Imagenes
    protected function index($Id)
    {

        $items = Imagene::select()
            ->whereHas('denuncias', function ($q) use ($Id) {
                return $q->where('denuncia_id',$Id)
                    ->where('parent__id',0);;
            })
            ->orderByDesc('id')
            ->orderBy('parent__id')
            ->paginate();

        $user = Auth::User();

        return view('denuncia.images.imagene_list',
            [
                'items' => $items,
                'titulo_catalogo' => "Imagenes de la denuncia: " . $Id,
                'titulo_header'   => '',
                'user' => $user,
                'searchInListImagene' => 'listImagenes',
                'newWindow' => true,
                'tableName' => $this->tableName,
                'newItem' => '/showModalImageneNew',
                'editItem' => '/showModalImageneEdit',
                'denuncia_id' => $Id,
                'removeItem' => 'removeImagene',
                'showEdit' => 'editDenuncia',
                'findDataInImagene'=>'findDataInImagene',
                'exportModel' => 20,
                'new2Item' => '/ImagenAImagenNew',
                'ImagenAImagenNew' => '/ImagenAImagenNew',
                'ImagenAImagenEdit' => '/ImagenAImagenEdit',
            ]
        );

    }

// ***************** ELIMINA EL ITEM VIA AJAX ++++++++++++++++++++ //
    protected function removeItem($id)
    {
        $nItem = explode(',', $id);
        if ( count($nItem) == 1) {

            $item = Imagene::withTrashed()->findOrFail($id);

            if ( isset($item) ) {
                if (!$item->trashed()) {
                    $item->forceDelete();
                } else {
                    $item->forceDelete();
                }
                $item->users()->detach($item->user__id);
                $den = Denuncia::find($item->denuncia__id);
                $den->imagenes()->detach($item->id);

                $this->F = new FuncionesController();
                $this->F->deleteImageDropZone($item->image, $this->disk);
                $this->F->deleteImageDropZone($item->image_thumb, $this->disk);
                return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
            } else {
                return Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
            }

        } else {
            return $this->removeItems($nItem);
        }
    }


// ***************** ELIMINA LOS REGISTROS SELECCIONADOS VIA AJAX ++++++++++++++++++++ //
    protected function removeItems($arrIds)
    {
        $valRet = Response::json(['mensaje' => 'none', 'data' => 'OK', 'status' => '200'], 200);
        foreach ($arrIds as $id){
            $item = Imagene::withTrashed()->findOrFail( $id );
            if (isset($item)) {
                try{
                    if (!$item->trashed()) {
                        $item->forceDelete();
                    } else {
                        $item->forceDelete();
                    }
                    $item->users()->detach($item->user__id);
                    $den = Denuncia::find($item->denuncia__id);
                    $den->imagenes()->detach($item->id);

                    $this->F = new FuncionesController();
                    $this->F->deleteImageDropZone($item->image,$this->disk);
                    $this->F->deleteImageDropZone($item->image_thumb,$this->disk);
                    $valRet =  Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

                }catch (QueryException $e){
                    $Msg = new MessageAlertClass();
                    $Msg->Message($e);
                }
            } else {
                $valRet =  Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
            }
        }
        return $valRet;
    }

    protected function showModalImageneNew($denuncia_id){
        $user = Auth::user();
        return view ('denuncia.images.imagene_upload',
            [
                'Route'       => 'saveImageneDen',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.denuncia.images.imagene_upload',
                'IsNew'       => true,
                'denuncia_id' => $denuncia_id,
                'user'        => $user,
                'removeItem' => 'removeImagene',

            ]
        );
    }

    protected function showModalImageneEdit($Id){
        $user = Auth::user();
        $item = Imagene::find($Id);
        //dd();
        //dd( Input::get('images') );

        return view ('SIAC.denuncia.images.imagene_edit_data',
            [
                'Route'       => 'saveImageneDen',
                'Method'      => 'POST',
                'items_forms' => 'SIAC.denuncia.images.__images.__imagene_edit_data',
                'IsNew'       => false,
                'item'        => $item,
                'user'        => $user,
                'removeItem'  => 'removeImagene',
            ]
        );
    }

    protected function saveImageneDen(ImageneRequest $request){
        $data = $request->only(['id']);
        if ( $data['id'] == 0 ){
            $item = $request->manage();
        }else{
            $request->manageEdit();
            $item = Imagene::find($data['id']);
        }
        if (isset($item)){
//            dd($item);
            return Response::json(['mensaje' => 'Información guardada con éxito!', 'data' => 'OK', 'status' => '200','filename'=>$item->image,'Id'=>$item->id], 200);
        }else{
            return Response::json(['mensaje' => 'Hubo un error!', 'data' => $item, 'status' => '422','filename'=>'','Id'=>-1], 200);
        }
    }

// IMAGEN A IMAGEN

    protected function ImagenAImagenNew($denuncia_id,$imagen_id){
        $user = Auth::user();
        return view ('denuncia.imagen_a_imagen.imagen_a_imagen_upload',
            [
                'saveImagenAImagenDen' => 'saveImagenAImagenDen',
                'denuncia_id'    => $denuncia_id,
                'imagen_id'      => $imagen_id,
                'removeItem'     => 'removeImagenParent',
                'user' => $user,
            ]
        );
    }

    protected function saveImagenAImagenDen(ImagenAImagenRequest $request){
        $item = $request->manage();
        if (isset($item)){
            return Response::json(['mensaje' => 'Información guardada con éxito!', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'Hubo un error!', 'data' => $item, 'status' => '422'], 200);
        }
    }


    protected function removeImagenParent($id)
    {
        $valRet = Response::json(['mensaje' => 'none', 'data' => 'OK', 'status' => '200'], 200);
//        foreach ($arrIds as $id){
            $item = Imagene::withTrashed()->findOrFail( $id );
            if (isset($item)) {
                try{
                    if (!$item->trashed()) {
                        $item->forceDelete();
                    } else {
                        $item->forceDelete();
                    }
                    $item->users()->detach($item->user__id);
                    $den = Denuncia::find($item->denuncia__id);
                    $den->imagenes()->detach($item->id);

                    $this->F = new FuncionesController();
                    $this->F->deleteImageDropZone($item->image,$this->disk);
                    $this->F->deleteImageDropZone($item->image_thumb,$this->disk);
                    $valRet =  Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

                }catch (QueryException $e){
                    $Msg = new MessageAlertClass();
                    $Msg->Message($e);
                }
            } else {
                $valRet =  Response::json(['mensaje' => 'Se ha producido un error.', 'data' => 'Error', 'status' => '200'], 200);
            }
//        }
        return $valRet;
    }




}
