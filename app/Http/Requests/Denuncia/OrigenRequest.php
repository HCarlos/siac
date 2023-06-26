<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Origen;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrigenRequest extends FormRequest
{


    protected $redirectRoute = 'editOrigen';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['origen'] = strtoupper(trim($attributes['origen']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'origen' => ['required','min:2',new Uppercase,'unique:origenes,origen,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'origen.required' => 'El :attribute requiere por lo menos de 2 caracter',
            'origen.unique' => 'El :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'origen' => 'Origen',
        ];
    }

    public function manage()
    {

        $Item = [
            'origen' => strtoupper($this->origen),
        ];

        try {

            if ($this->id == 0) {
                $item = Origen::create($Item);
            } else {
                $item = Origen::find($this->id);
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
            return $url->route('newOrigen');
        }
    }



}
