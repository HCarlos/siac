<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Domicilio;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Domicilios\Asentamiento;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AsentamientoRequest extends FormRequest
{



    protected $redirectRoute = 'editAsentamiento';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['asentamiento'] = strtoupper(trim($attributes['asentamiento']));
        $this->replace($attributes);
        return parent::all();
    }


    public function rules()
    {
        return [
            'asentamiento' => ['required','min:2',new Uppercase,'unique:asentamientos,asentamiento,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'asentamiento.required' => 'El :attribute requiere por lo menos de 2 caracteres',
            'asentamiento.unique' => 'La :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'asentamiento' => 'Asentamiento',
        ];
    }

    public function manage()
    {

        $Item = [
            'asentamiento' => strtoupper($this->asentamiento),
            'nomenclatura' => strtoupper($this->nomenclatura),
        ];

        try {
            if ($this->id == 0) {
                $item = Asentamiento::create($Item);
            } else {
                $item = Asentamiento::find($this->id);
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
            return $url->route('newAsentamiento');
        }
    }



}
