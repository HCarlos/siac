<?php

namespace App\Http\Requests\API;

use App\Events\APIDenunciaEvent;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Mobiles\Denunciamobile;
use App\Models\Mobiles\Imagemobile;
use App\Models\Mobiles\Serviciomobile;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DenunciaAddImageAPIRequest extends FormRequest{


    protected $disk = 'mobile_denuncia';
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
        return [
            'imagen' => ['required'],
            'denunciamobile_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'imagen.required' => 'Se requiere la :attribute.',
            'denunciamobile_id.required' => 'Se requiere la :attribute.',
        ];
    }

    public function attributes()
    {
        return [
            'imagen' => 'Imagen',
            'denuncia_id' => 'Denuncia',
        ];
    }

    public function manage()
    {
        try {
            ini_set('max_execution_time', 300000);
            app()['cache']->forget('spatie.permission.cache');

            $DenMob = Denunciamobile::find($this->denunciamobile_id);
            if ( $DenMob ){
                $this->manageImage($DenMob);
            }else{
                return ["status"=>0, "msg"=>"Ocurrió un error desconocido."];
            }

        } catch (QueryException $e) {
            return ["status"=>0, "msg"=>$e->getMessage()];
        }
        return $DenMob;
    }


    public function manageImage(Denunciamobile $denunciamobile){

        $this->F = new FuncionesController();

        try {


            $image = $this->imagen;
            $imageContent = $this->imageBase64Content($image);

            $file = $imageContent;
            $randomImageNameSingular = $this->randomImageNameSingular();
            $fileName = $randomImageNameSingular.'_'.$denunciamobile->id.'.png';
            $fileName2 = '_'.$randomImageNameSingular.'_'.$denunciamobile->id.'.png';
            $thumbnail = '_thumb_'.$randomImageNameSingular.'_'.$denunciamobile->id.'.png';
//            Storage::disk($this->disk)->put($fileName, File::get($file) );
            Storage::disk($this->disk)->put($fileName, $file );
            $this->F->fitImage( $file, $fileName2, 300, 300, true, $this->disk,"MOBILE_DENUNCIA_ROOT" );
            $this->F->fitImage( $file, $thumbnail, 128, 128, true, $this->disk,"MOBILE_DENUNCIA_ROOT", "png" );

            $fechaActual = Carbon::now()->format('Y-m-d h:m:s');
            $Item = [
                'fecha'             => $fechaActual,
                'user_id'           => $this->user_id,
                'denunciamobile_id' => $denunciamobile->id,
                'root'              => 'mobile_denuncia/',
                'filename'          => $fileName,
                'filename_png'      => $fileName2,
                'filename_thumb'    => $thumbnail,
                'latitud'           => $denunciamobile->latitud,
                'longitud'          => $denunciamobile->longitud,
            ];

            $imm = Imagemobile::create($Item);

            if ($imm){
                event(new APIDenunciaEvent($denunciamobile->id, $denunciamobile->user_id));
                $imm->denuncias()->attach($denunciamobile);
                $imm->users()->attach($this->user_id);
                return $imm;
            }
            return ["status"=>0, "msg"=>"Error de imagen desconocido..."];

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




    public function failedValidation(Validator $validator){
        $err = "";
        foreach ($validator->errors()->getMessages() as $ss){
            $err .= $err == "" ?  $ss[0] : " :: ". $ss[0];
        }
        throw new HttpResponseException(response()->json([
            'status' => 0,
            'msg'    => $err,
        ]));
    }







}
