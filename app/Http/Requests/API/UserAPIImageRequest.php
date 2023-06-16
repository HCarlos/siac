<?php

namespace App\Http\Requests\API;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Rules\IsCURPRule;
use App\User;
use http\Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UserAPIImageRequest extends FormRequest{

    protected $disk = 'profile';
    protected $F;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [ ];
    }

    public function manage(){

        $ip     = $_SERVER['REMOTE_ADDR'];
        $host   = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp  = 1;
        $this->F = new FuncionesController();

        try {

            $user = User::find($this->user_id);

            $image = $this->photo;
            $imageContent = $this->imageBase64Content($image);

            $file = $imageContent;
            $fileName = $user->id.'.png';
            $fileName2 = '_'.$user->id.'.png';
            $thumbnail = '_thumb_'.$user->id.'.png';
//            Storage::disk($this->disk)->put($fileName, File::get($file) );
            Storage::disk($this->disk)->put($fileName, $file );
            $this->F->fitImage( $file, $fileName2, 300, 300, true, "profile","PROFILE_ROOT" );
            $this->F->fitImage( $file, $thumbnail, 128, 128, true, "profile","PROFILE_ROOT", "png" );

            $user->root = 'profile/';
            $user->filename = $fileName;
            $user->filename_png = $fileName2;
            $user->filename_thumb = $thumbnail;
            $user->ip = $ip;
            $user->host = $host;
            $user->empresa_id = $idemp;
            $user->save();
            return $user;

        }catch (Exception $e){
            return ["status"=>0, "msg"=>$e->getMessage()];
        }
        return $user;


    }


    private function imageBase64Content($image) {
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        return base64_decode($image);

    }

    private function randomImageName() {
        return Str::random(10) . '.' . 'png';
    }



}
