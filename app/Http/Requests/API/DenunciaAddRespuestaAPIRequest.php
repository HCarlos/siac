<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\API;

use App\Events\APIDenunciaEvent;
use App\Models\Mobiles\Denunciamobile;
use App\Models\Mobiles\Respuestamobile;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DenunciaAddRespuestaAPIRequest extends FormRequest{

    protected $F;

    public function authorize(){
        return true;
    }

    public function rules() {
        return [
            'respuesta' => ['required'],
            'denunciamobile_id' => ['required'],
        ];
    }

    public function messages() {
        return [
            'respuesta.required' => 'Se requiere una :attribute.',
            'denunciamobile_id.required' => 'Se requiere la :attribute.',
        ];
    }

    public function attributes() {
        return [
            'respuesta' => 'Respuesta',
            'denuncia_id' => 'Denuncia',
        ];
    }

    public function manage() {
        try {
            ini_set('max_execution_time', 300000);
            app()['cache']->forget('spatie.permission.cache');

            $DenMob = Denunciamobile::find($this->denunciamobile_id);
            if ( $DenMob ){

                $fechaActual = Carbon::now()->format('Y-m-d h:m:s');
                $Item = [
                    'fecha' => $fechaActual,
                    'user_id' => $this->user_id,
                    'denunciamobile_id' => $DenMob->id,
                    'respuesta' => $this->respuesta,
                    'observaciones' => $this->observaciones,
                ];

                $imm = Respuestamobile::create($Item);

                if ($imm) {
                    event(new APIDenunciaEvent($DenMob->id, $DenMob->user_id));
                    $imm->denuncias()->attach($DenMob);
                    $imm->users()->attach($this->user_id);

                    return ["status"=>1, "msg"=>$imm];
                }
            }else{
                return ["status"=>0, "msg"=>"Ocurrió un error desconocido."];
            }

        } catch (QueryException $e) {
            return ["status"=>0, "msg"=>$e->getMessage()];
        }
        return $DenMob;
    }


    public function failedValidation(Validator $validator) {
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
