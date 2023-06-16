<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Funciones\FuncionesController;
use http\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class StorageProfileController extends Controller
{
    protected $redirectTo = 'showEditProfilePhoto/';
    protected $disk = 'profile';
    protected $F;
    public function __construct(){
        $this->middleware('auth');
        $this->F = new FuncionesController();
    }

    public function subirArchivoProfile(Request $request)
    {
        $ip     = $_SERVER['REMOTE_ADDR'];
        $host   = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp  = 1;
        $data    = $request->all();
        $user = Auth::User();

        try {
            $validator = Validator::make($data, [
                'photo' => "required|mimes:".config('atemun.images_type_validate')."|max:10000",
            ]);
            if ($validator->fails()){
                return redirect('showEditProfilePhoto/')
                    ->withErrors($validator)
                    ->withInput();

            }
            $file = $request->file('photo');
            $ext = $file->extension();
            $fileName = $user->id.'.' . $ext;
            $fileName2 = '_'.$user->id.'.png';
            $thumbnail = '_thumb_'.$user->id.'.png';
            Storage::disk($this->disk)->put($fileName, File::get($file));
            $this->F->fitImage( $file, $fileName2, 300, 300, true, "profile","PROFILE_ROOT" );
            $this->F->fitImage( $file, $thumbnail, 128, 128, true, "profile","PROFILE_ROOT", $ext );

            $user->root = 'profile/';
            $user->filename = $fileName;
            $user->filename_png = $fileName2;
            $user->filename_thumb = $thumbnail;
            $user->ip = $ip;
            $user->host = $host;
            $user->empresa_id = $idemp;
            $user->save();
            return redirect($this->redirectTo);

        }catch (Exception $e){
            dd($e);
        }
        return redirect($this->redirectTo);

    }

    public function quitarArchivoProfile()
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

        return redirect($this->redirectTo);

    }
}
