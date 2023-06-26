<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia\Respuesta;

use App\Classes\MessageAlertClass;
use App\Classes\NotificationsMobile\SendNotificationFCM;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Respuesta;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class RespuestaRequest extends FormRequest
{

    protected $redirectRoute = '/showModalRespuestaEdit';

    public function authorize()
    {
        return true;
    }
    public function validationData(){
        $attributes = parent::all();
        $attributes['respuesta'] = strtoupper(trim($attributes['respuesta']));
        $this->replace($attributes);
        return parent::all();
    }


    public function rules()
    {
        return [
            'fecha'         => ['required','date'],
            'respuesta'     => ['required','string'],
        ];
    }

    public function messages()
    {
        return [
            'respuesta.required' => 'La RESPUESTA es obligatoria.',
            'fecha.required' => 'La FECHA es obligatoria.',
            'fecha.date' => 'La FECHA se requiere en formato dd/mm/aaaa.',
        ];
    }

    public function attributes()
    {
        return [
            'respuesta' => 'Respuesta',
        ];
    }


    public function manage()
    {
        try {
            $this->user__id = Auth::id();
            $fechaActual = Carbon::parse($this->fecha)->format('Y-m-d h:m:s');
            $horaActual = Carbon::now()->format('hh:mm:ss');
            $Item = [
                'fecha'         => $fechaActual, //.' '.$horaActual,
                'respuesta'     => strtoupper(trim($this->respuesta)),
                'observaciones' => strtoupper(trim($this->observaciones)),
                'user__id'      => $this->user__id,
                'denuncia__id'  => $this->denuncia__id,
            ];

            if ( (int) $this->id === 0) {
                $item = Respuesta::create($Item);
            } else {
                $item = Respuesta::find($this->id);
                $this->detaches($item);
                $item->update($Item);
            }
            $this->attaches($item);
            $cfm = new SendNotificationFCM();
            $cfm->sendNotificationMobile($item,1);
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }
        return $item;

    }

    public function attaches($Item){

        $Item->users()->attach($this->user__id);
        $den = Denuncia::find($this->denuncia__id);
        $den->respuestas()->attach($Item);
        return $Item;
    }

    public function detaches($Item){
        $Item->users()->detach($this->user__id);
        $den = Denuncia::find($this->denuncia__id);
        $den->respuestas()->detach($this->id);

        return $Item;
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['denuncia_id'=>$this->denuncia__id,'Id'=>$this->id]);
        }else{
            return $url->route('/showModalRespuestaNew',['denuncia_id'=>$this->denuncia__id]);
        }
    }




    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response(
            $this->formatErrors($validator)
        ));
    }
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->getMessages();
    }
    public function response(array $errors)
    {
        if ($this->ajax() || $this->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);

    }





}
