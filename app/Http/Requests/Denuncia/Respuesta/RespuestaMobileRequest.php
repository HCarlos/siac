<?php

namespace App\Http\Requests\Denuncia\Respuesta;

use App\Classes\MessageAlertClass;
use App\Classes\NotificationsMobile\SendNotificationFCM;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Respuesta;
use App\Models\Mobiles\Denunciamobile;
use App\Models\Mobiles\Respuestamobile;
use App\Models\Users\UserMobile;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class RespuestaMobileRequest extends FormRequest{

    protected $redirectRoute = '/showModalRespuestaEdit';

    public function authorize(){
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
            'respuesta'     => ['required','string'],
        ];
    }
    public function messages()
    {
        return [
            'respuesta.required' => 'La RESPUESTA es obligatoria.',
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
            $this->user_id = Auth::id();
            $fechaActual = Carbon::now()->format('Y-m-d h:m:s');
            $horaActual = Carbon::now()->format('hh:mm:ss');
            $Item = [
                'fecha'         => $fechaActual, //.' '.$horaActual,
                'respuesta'     => strtoupper(trim($this->respuesta)),
                'observaciones' => "",
                'user_id'      => $this->user_id,
                'denunciamobile_id'  => $this->denunciamobile_id,
            ];

            if ((int)$this->id == 0) {
                $item = Respuestamobile::create($Item);
            } else {
                $item = Respuestamobile::find($this->id);
                $this->detaches($item);
                $item->update($Item);
            }
            $this->attaches($item);
            $cfm = new SendNotificationFCM();
            $cfm->sendNotificationMobile($item,0);
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }
        return $item;

    }

    public function attaches($Item){

        $Item->users()->attach($this->user_id);
        $den = Denunciamobile::find($this->denunciamobile_id);
        $den->respuestas()->attach($Item);
        return $Item;
    }

    public function detaches($Item){
        $Item->users()->detach($this->user_id);
        $den = Denunciamobile::find($this->denunciamobile_id);
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
