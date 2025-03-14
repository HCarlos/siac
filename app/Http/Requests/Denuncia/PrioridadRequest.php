<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Prioridad;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PrioridadRequest extends FormRequest
{


    protected $redirectRoute = 'editPrioridad';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['prioridad'] = strtoupper(trim($attributes['prioridad']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'prioridad' => ['required','min:2',new Uppercase,'unique:prioridades,prioridad,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'prioridad.required' => 'La :attribute requiere por lo menos de 2 caracteres',
            'prioridad.unique' => 'La :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'prioridad' => 'Prioridad',
        ];
    }

    public function manage()
    {

        $Item = [
            'prioridad'        => strtoupper($this->prioridad),
            'class_css'        => $this->class_css,
            'predeterminado'   => $this->predeterminado==1?true:false,
            'orden_impresion'  => $this->orden_impresion,
            'ambito_prioridad' => $this->ambito_prioridad,
        ];

        try {
            if ($this->predeterminado==1) {
//                $items = Prioridad::where("predeterminado",true);
//                $items->update(["predeterminado" => false]);

                Prioridad::where('predeterminado',true)
                    ->where('ambito_prioridad',$this->ambito_prioridad)
                    ->update(['predeterminado'=>false]);

            }
            if ($this->id == 0) {
                $item = Prioridad::create($Item);
            } else {
                $item = Prioridad::find($this->id);
                $item->update($Item);
            }
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }
        return $item;
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('newPrioridad');
        }
    }




}
