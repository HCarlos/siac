<?php
/*
 * Copyright (c) 2022. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class StorageMobileProfileController extends Controller{

    protected $disk = 'mobile_profile';
    protected $F;
    public function __construct(){
        $this->middleware('auth');
        $this->F = new FuncionesController();
    }


    public function subirArchivoProfile(Request $request)
    {
        $Msg = "OK";
        $ip     = $_SERVER['REMOTE_ADDR'];
        $host   = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp  = 1;
        $data    = $request->all();
        $usr =  $request->post('user_id');
        $user = User::find($usr);

        try {
//            $validator = Validator::make($data, [
//                'photo' => "required|mimes:".config('atemun.images_type_validate')."|max:10000",
//            ]);
//            if ($validator->fails()){
//                return redirect('showEditMobileProfilePhoto/')
//                    ->withErrors($validator)
//                    ->withInput();
//            }
            $file = $request->file('photo');
            $ext = $file->extension();
            $fileName = $user->id.'.' . $ext;
            $fileName2 = '_'.$user->id.'.png';
            $thumbnail = '_thumb_'.$user->id.'.png';
            Storage::disk($this->disk)->put($fileName, File::get($file));
            $this->F->fitImage( $file, $fileName2, 300, 300, true, "mobile_profile","MOBILE_PROFILE_ROOT" );
            $this->F->fitImage( $file, $thumbnail, 128, 128, true, "mobile_profile","MOBILE_PROFILE_ROOT", $ext );

            $user->root = 'mobile/profile/';
            $user->filename = $fileName;
            $user->filename_png = $fileName2;
            $user->filename_thumb = $thumbnail;
            $user->ip = $ip;
            $user->host = $host;
            $user->empresa_id = $idemp;
            $user->save();
            return $Msg;

        }catch (Exception $e){
            $Msg = $e->getMessage();
        }
        return $Msg;

    }

    public function quitarArchivoMobileProfile()
    {
        $user = Auth::user();
        Storage::disk($this->disk)->delete($user->filename);
        Storage::disk($this->disk)->delete($user->filename_png);
        Storage::disk($this->disk)->delete($user->filename_thumb);

        $user->filename = '';
        $user->filename_png = '';
        $user->filename_thumb = '';
        $user->root = '';
        $user->save();

        return "OK";

    }

}
