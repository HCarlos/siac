<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia\Imagene;

use App\Classes\MessageAlertClass;
use App\Events\APIDenunciaEvent;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Imagene;
use App\Models\Mobiles\Denunciamobile;
use App\Models\Mobiles\Imagemobile;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImagenAPIRequest extends FormRequest
{




    protected $disk = 'denuncia';
    protected $F;

    public function authorize()
    {
        return true;
    }

    public function manage(){
        $this->F = new FuncionesController();

        try {

            $fechaActual = Carbon::now()->format('Y-m-d h:m:s');
            $Item = [
                'fecha'         => $fechaActual,
                'user__id'      => $this->user_id,
                'denuncia__id'  => $this->denuncia_id,
            ];
//            dd($Item->momento);
            if ((int)$this->id === 0) {
                $item = Imagene::create($Item);
            }
            $this->attaches($item);
            $this->manageImage();

        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return $Msg->Message($e);
        }
        return $item;

    }


    public function attaches($Item){

        $Item->users()->attach($this->user_id);
        $den = Denuncia::find($this->denuncia_id);
        $den->imagenes()->attach($Item);
        return $Item;
    }


    public function manageImage(){

        $this->F = new FuncionesController();

        try {


            $image = $this->imagen;
            $imageContent = $this->imageBase64Content($image);

            $file = $imageContent;
            $randomImageNameSingular = $this->randomImageNameSingular();
            $fileName = $randomImageNameSingular.'_'.$this->denuncia_id.'.png';
            $fileName2 = '_'.$randomImageNameSingular.'_'.$this->denuncia_id.'.png';
            $thumbnail = '_thumb_'.$randomImageNameSingular.'_'.$this->denuncia_id.'.png';
//            Storage::disk($this->disk)->put($fileName, File::get($file) );
            Storage::disk($this->disk)->put($fileName, $file );
            $this->F->fitImage( $file, $fileName2, 300, 300, true, $this->disk,"DENUNCIA_ROOT" );
            $this->F->fitImage( $file, $thumbnail, 128, 128, true, $this->disk,"DENUNCIA_ROOT", "png" );

            event(new APIDenunciaEvent($this->denuncia_id, $this->user_id));

            return ["status"=>1, "msg"=>"Imagen guardada con éxito..."];

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

    private function randomImageNameSingular() {
        return Str::random(25) ;
    }




}
