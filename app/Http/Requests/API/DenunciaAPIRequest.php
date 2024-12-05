<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\API;

use App\Events\APIDenunciaEvent;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Denuncias\_viServicios;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Imagene;
use App\Models\Mobiles\Denunciamobile;
use App\Models\Mobiles\Imagemobile;
use App\Models\Mobiles\Serviciomobile;
use App\User;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DenunciaAPIRequest extends FormRequest{

    protected $disk = 'mobile_denuncia';
    protected $F;
    protected $DenMobGen = null;


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
            'denuncia' => ['required','min:5'],
            'latitud' => ['required','numeric','gt:0'],
            'longitud' => ['required','numeric','lt:0'],
        ];
    }

    public function messages()
    {
        return [
            'imagen.required' => 'Se requiere la :attribute.',
            'denuncia.required' => 'Se requiere la :attribute.',
            'denuncia.min' => 'La :attribute debe ser por lo menos de 5 caracteres.',
            'latitud.required' => 'Se requiere la :attribute.',
            'latitud.numeric' => 'La :attribute debe ser un valor numérico.',
            'latitud.gt' => 'La :attribute debe ser mayor que cero.',
            'longitud.required' => 'Se requiere la :attribute.',
            'longitud.numeric' => 'La :attribute debe ser un valor numérico.',
            'longitud.lt' => 'La :attribute debe ser menor que cero.',
        ];
    }

    public function attributes()
    {
        return [
            'imagen' => 'Imagen',
            'latitud' => 'Latitud',
            'longitud' => 'Longitud',
        ];
    }

    public function manage(){

        try {
            ini_set('max_execution_time', 300000);
            app()['cache']->forget('spatie.permission.cache');

            $tipo_mobile = strtoupper(trim($this->tipo_mobile));

            return Str::of($tipo_mobile);



//            $Ser = Serviciomobile::all()->where("servicio",trim($this->servicio))->first();

            if ($tipo_mobile === "ANDROID"){
                $srv = explode('_',$this->servicio_id);
                $Ser = Serviciomobile::query()->where("id",$srv[1])->first();
            }else{
                $Ser = Serviciomobile::query()->where("id",$this->id)->first();
            }

            $F           = new FuncionesController();
            $filters      = strtolower($this->ubicacion_google);
            $filters      = $F->str_sanitizer($filters);
            $tsString     = $F->string_to_tsQuery( strtoupper($filters),' & ');

            $Ubi = Ubicacion::query()
                ->search($tsString)
                ->orderBy('id')
                ->first();

            if (is_null($Ubi)){
                $Ubi = Ubicacion::find($this->ubicacion_id)->first();
            }

            $DenMob = Denunciamobile::create([
                'fecha'             => now(),
                'denuncia'          => strtoupper(trim($this->denuncia)),
                'tipo_mobile'       => strtoupper(trim($this->tipo_mobile)),
                'marca_mobile'      => strtoupper(trim($this->marca_mobile)),
                'serviciomobile_id' => $Ser ? $Ser->id : 1,
                'dependencia_id'    => $Ser ? $Ser->dependencia_id : 1,
                'servicio_id'       => $Ser ? $Ser->servicio_id : 1,
                'estatus_id'        => 8 ,
                'ubicacion_id'      => $Ubi->id,
                'ubicacion'         => strtoupper(trim($Ubi->Ubicacion ?? $this->ubicacion_google)),
                'ubicacion_google'  => strtoupper(trim($this->ubicacion_google)),
                'latitud'           => $this->latitud,
                'longitud'          => $this->longitud,
                'user_id'           => $this->user_id,
            ]);

            $this->DenMobGen = $DenMob;

            $Item = [
                'fecha_ingreso'                => now(), // Carbon::now(), //Carbon::now($this->fecha_ingreso)->format('Y-m-d hh:mm:ss'),
                'oficio_envio'                 => now(),
                'folio_sas'                    => "",
                'fecha_oficio_dependencia'     => now(),
                'fecha_limite'                 => now(),
                'fecha_ejecucion'              => now(),
                'descripcion'                  => strtoupper($this->denuncia),
                'referencia'                   => $this->ubicacion_google ?? '',
                'clave_identificadora'         => "",
                'calle'                        => strtoupper($Ubi->calle),
                'num_ext'                      => strtoupper($Ubi->num_ext),
                'num_int'                      => strtoupper($Ubi->num_int),
                'colonia'                      => strtoupper($Ubi->colonia),
                'comunidad'                    => strtoupper($Ubi->comunidad),
                'ciudad'                       => strtoupper($Ubi->ciudad),
                'municipio'                    => strtoupper($Ubi->municipio),
                'estado'                       => strtoupper($Ubi->estado),
                'cp'                           => strtoupper($Ubi->cp),
                'latitud'                      => $this->latitud ?? 0.0000,
                'longitud'                     => $this->longitud ?? 0.0000,
                'altitud'                      => $this->altitud ?? 0.0000,
                'searchGoogle'                 => $this->ubicacion_google ?? '',
                'gd_ubicacion'                 => $this->ubicacion_google ?? '',
                'prioridad_id'                 => 2,
                'origen_id'                    => 24,
                'dependencia_id'               => $Ser->dependencia_id,
                'ubicacion_id'                 => $Ubi->id,
                'servicio_id'                  => $Ser->servicio_id,
                'estatus_id'                   => 8,
                'ciudadano_id'                 => $this->user_id,
                'creadopor_id'                 => $this->user_id,
                'modificadopor_id'             => $this->user_id,
                'domicilio_ciudadano_internet' => strtoupper(trim($this->ubicacion_google))  ?? '' ,
                'observaciones'                => strtoupper(trim($this->marca_mobile))." - ".$this->DenMobGen->id,
                'ip'                           => "",
                'host'                         => "",
                'denunciamobile_id'            => $this->DenMobGen->id,
                'ambito'                       => $this->ambito ?? 2,
            ];

            $obj = $this->guardarDenunciaMobileADenuncia($Item);

            if ( $DenMob ){
                $img = $this->manageImage($DenMob, $obj);
            }else{
                return ["status"=>0, "msg"=>"Ocurrió un error desconocido."];
            }
            return $DenMob;
        } catch (QueryException $e) {
            return ["status"=>0, "msg"=>$e->getMessage()];
        }
        return $DenMob;
    }

    public function manageImage(Denunciamobile $denunciamobile, $ITEM){

        $this->F = new FuncionesController();
        $user = User::find($denunciamobile->user_id);

        try {
            $image = $this->imagen;
            $imageContent = $this->imageBase64Content($image);
            $file = $imageContent;
            $randomImageNameSingular = $this->randomImageNameSingular();
            $fileName = $randomImageNameSingular.'_'.$denunciamobile->id.'.png';
            $fileName2 = '_'.$randomImageNameSingular.'_'.$denunciamobile->id.'.png';
            $thumbnail = '_thumb_'.$randomImageNameSingular.'_'.$denunciamobile->id.'.png';
            Storage::disk($this->disk)->put($fileName, $file );
            $this->F->fitImage( $file, $fileName2, 300, 300, true, $this->disk,"MOBILE_DENUNCIA_ROOT" );
            $this->F->fitImage( $file, $thumbnail, 128, 128, true, $this->disk,"MOBILE_DENUNCIA_ROOT", "png" );

            $fechaActual = Carbon::now()->format('Y-m-d h:m:s');
            $Item = [
                'fecha'             => $fechaActual,
                'user_id'           => $denunciamobile->user_id,
                'denunciamobile_id' => $denunciamobile->id,
                'root'              => 'mobile_denuncia/',
                'filename'          => $fileName,
                'filename_png'      => $fileName2,
                'filename_thumb'    => $thumbnail,
                'latitud'           => $denunciamobile->latitud,
                'longitud'          => $denunciamobile->longitud,
            ];

            $imm = Imagemobile::create($Item);

            $__Item = [
                'fecha'        => $imm->fecha,
                'user__id'     => $ITEM->ciudadano_id,
                'denuncia__id' => $ITEM->id,
                'root'         => config('atemun.public_url'),
                'image'        => $fileName,
                'image_thumb'  => $thumbnail,
                'titulo'       => $ITEM->descripcion,
                'descripcion'  => 'mobile',
            ];

            $_item = Imagene::create($__Item);
            $_item->users()->attach($ITEM->ciudadano_id);
            $den = Denuncia::find($ITEM->id);
            $den->imagenes()->attach($_item);

//            dd($imm);

            if ($imm){
                event(new APIDenunciaEvent($denunciamobile->id, $denunciamobile->user_id));
                $imm->denuncias()->attach($denunciamobile);
                $imm->users()->attach($denunciamobile->user_id);
                $denunciamobile->ciudadanos()->attach($denunciamobile->user_id);
                return $denunciamobile;
            }

            return ["status"=>0, "msg"=>"Error de imagen desconocido..."];

        }catch (Exception $e){
//            dd($e->getMessage());
            return ["status"=>0, "msg"=>$e->getMessage()];
        }

        return $denunciamobile;


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

    protected function guardarDenunciaMobileADenuncia($Item){
        $item = Denuncia::create($Item);
        $this->attachesDenunciaMobileADenuncia($item);
        $this->DenMobGen->denuncia_id = $item->id;
        $this->DenMobGen->save();
        return $item;
    }

    public function attachesDenunciaMobileADenuncia($Item){
        try {
                $Obj = $Item->prioridades()->attach($Item->prioridad_id);
                $Obj = $Item->origenes()->attach($Item->origen_id);
                $Obj = $Item->dependencias()->attach($Item->dependencia_id,['servicio_id'=>$Item->servicio_id,'estatu_id'=>$Item->estatus_id,'fecha_movimiento' => now() ]);
                $Obj = $Item->ubicaciones()->attach($Item->ubicacion_id);
                $Obj = $Item->servicios()->attach($Item->servicio_id);
                $Obj = $Item->estatus()->attach($Item->estatus_id,['ultimo'=>true]);
                $Obj = $Item->ciudadanos()->attach($Item->ciudadano_id);
                $Obj = $Item->creadospor()->attach($Item->creadopor_id);
                $Obj = $Item->modificadospor()->attach($Item->modificadopor_id);

        }catch (\Doctrine\DBAL\Driver\Exception $e){

        }

        return $Item;

    }





}
