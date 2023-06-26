<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\User;

use App\Classes\MessageAlertClass;
use App\Models\Users\Categoria;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
{

    protected $redirectRoute = 'editCategoria';

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categoria' => ['required','min:4','unique:categorias,categoria,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'categoria.required' => 'El :attribute requiere por lo menos de 4 caracter',
            'categoria.unique' => 'La :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'categoria' => 'Categoria',
        ];
    }

    public function manage()
    {

        $Item = [
            'categoria' => strtoupper($this->categoria),
        ];

        try {

            if ($this->id == 0) {
                $item = Categoria::create($Item);
            } else {
                $item = Categoria::find($this->id);
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
            return $url->route('newCategoria');
        }
    }

}
