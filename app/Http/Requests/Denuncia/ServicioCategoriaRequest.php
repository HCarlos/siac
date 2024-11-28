<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\ServicioCategoria;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ServicioCategoriaRequest extends FormRequest
{


    protected $redirectRoute = 'editServicioCategoria';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['categoria_servicios'] = strtoupper(trim($attributes['categoria_servicios']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'categoria_servicios' => ['required','min:2',new Uppercase,'unique:servicioscategorias,categoria_servicios,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'categoria_servicios.required' => 'El :attribute requiere por lo menos de 2 caracter',
            'categoria_servicios.unique' => 'El :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'categoria_servicios' => 'Categoría de Servicios',
        ];
    }

    public function manage()
    {

        $Item = [
            'categoria_servicios' => strtoupper($this->categoria_servicios),
            'enlaces_unidades' => strtoupper($this->enlaces_unidades) ?? '',
        ];

        try {

            if ($this->id == 0) {
                $item = ServicioCategoria::create($Item);
            } else {
                $item = ServicioCategoria::find($this->id);
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
            return $url->route('newServicioCategoria');
        }
    }



}
