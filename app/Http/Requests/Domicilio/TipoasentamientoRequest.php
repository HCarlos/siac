<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Domicilio;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Domicilios\Tipoasentamiento;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TipoasentamientoRequest extends FormRequest
{


    protected $redirectRoute = 'editTipoasentamiento';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['tipoasentamiento'] = strtoupper(trim($attributes['tipoasentamiento']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'tipoasentamiento' => ['required','min:2',new Uppercase(),'unique:tipoasentamientos,tipoasentamiento,'.$this->id],
        ];
    }

    public function manage()
    {
        $Item = [
            'tipoasentamiento' => strtoupper($this->tipoasentamiento),
            'nomenclatura'     => strtoupper($this->nomenclatura),
        ];

        try {
            if ($this->id == 0) {
                $item = Tipoasentamiento::create($Item);
            } else {
                $item = Tipoasentamiento::find($this->id);
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
            return $url->route('newTipoasentamiento');
        }
    }






}
