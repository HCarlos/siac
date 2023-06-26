<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Domicilio;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Domicilios\Calle;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CalleRequest extends FormRequest
{




    protected $redirectRoute = 'editCalle';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['calle'] = strtoupper(trim($attributes['calle']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules(){
        return [
            'calle' => ['required','min:2',new Uppercase,'unique:calles,calle,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'calle.required' => 'El :attribute requiere por lo menos de 2 caracteres',
            'calle.unique' => 'La :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'calle' => 'Calle',
        ];
    }

    public function manage()
    {

        $Item = [
            'calle' => strtoupper($this->calle),
        ];

        try {
            if ($this->id == 0) {
                $item = Calle::create($Item);
            } else {
                $item = Calle::find($this->id);
                Ubicacion::detachesCalle($this->id);
                $item->update($Item);
                Ubicacion::attachesCalle($this->id);
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
            return $url->route('newCalle');
        }
    }








}
