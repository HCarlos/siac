<?php
/*
 * Copyright (c) 2022. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\Storage\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Servicio;
use App\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StorageMobileServicioController extends Controller{


    protected $disk = 'mobile_servicio';
    protected $F;
    public function __construct(){
        $this->middleware('auth');
        $this->F = new FuncionesController();
    }


    public function subirArchivoMobileServicio(Request $request, Servicio $ServicioObject)
    {
        $Msg = "OK";
        $ip     = $_SERVER['REMOTE_ADDR'];
        $host   = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp  = 1;
        $data    = $request->all();
        $servicio = Servicio::find($ServicioObject->id);
        $data    = $request->all(['url_image_mobile']);
        try {
//            $validator = Validator::make($data, [
//                'photo' => "required|mimes:".config('atemun.images_type_validate')."|max:10000",
//            ]);
//            if ($validator->fails()){
//                return redirect('showEditMobileProfilePhoto/')
//                    ->withErrors($validator)
//                    ->withInput();
//            }
            $file = $request->file('url_image_mobile');
            $ext = $file->extension();
            $fileName = $servicio->id.'.' . $ext;
            $fileName2 = '_'.$servicio->id.'.png';
            $thumbnail = '_thumb_'.$servicio->id.'.png';
            Storage::disk($this->disk)->put($fileName, File::get($file));
            $this->F->fitImage( $file, $fileName2, 300, 300, true, "mobile_servicio","MOBILE_SERVICIO_ROOT" );
            $this->F->fitImage( $file, $thumbnail, 128, 128, true, "mobile_servicio","MOBILE_SERVICIO_ROOT", $ext );

            $servicio->root = 'mobile/servicio/';
            $servicio->filename = $fileName;
            $servicio->filename_png = $fileName2;
            $servicio->filename_thumb = $thumbnail;
            $servicio->url_image_mobile = 'storage/' . $servicio->root . $servicio->filename;
            $servicio->save();
            return $Msg;

        }catch (Exception $e){
            $Msg = $e->getMessage();
        }
        return $Msg;

    }

    public function quitarArchivoMobileServicio($Id){
        $Msg = "/editServicio/".$Id;
        $servicio = Servicio::find($Id);
        if ($servicio){
            Storage::disk($this->disk)->delete($servicio->filename);
            Storage::disk($this->disk)->delete($servicio->filename_png);
            Storage::disk($this->disk)->delete($servicio->filename_thumb);

            $servicio->filename = '';
            $servicio->filename_png = '';
            $servicio->filename_thumb = '';
            $servicio->root = '';
            $servicio->is_visible_mobile = false;
            $servicio->nombre_mobile = '';
            $servicio->url_image_mobile = '';
            $servicio->orden_image_mobile = 0;
            $servicio->save();
        }

        return redirect($Msg);

    }

}
