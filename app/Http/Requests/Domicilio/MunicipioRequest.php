<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Domicilio;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Domicilios\Municipio;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;

class MunicipioRequest extends FormRequest
{


    protected $redirectRoute = 'editMunicipio';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'municipio' => ['required','min:2',new Uppercase,'unique:municipios,municipio,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'municipio.required' => 'El :attribute requiere por lo menos de 2 caracteres',
            'municipio.unique' => 'La :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'municipio' => 'Municipio',
        ];
    }

    public function manage()
    {
        $Item = [
            'municipio' => strtoupper($this->municipio),
        ];

        try {
            if ($this->id == 0) {
                $item = Municipio::create($Item);
            } else {
                $item = Municipio::find($this->id);
                $item->update($Item);
            }
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return $Msg->Message($e);
        }
        return $item;
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('newMunicipio');
        }
    }





}
