<?php

namespace App\Http\Requests\Domicilio;

use App\Models\Catalogos\Domicilios\Ciudad;
use App\Rules\Uppercase;
use Illuminate\Foundation\Http\FormRequest;
use App\Classes\MessageAlertClass;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;

class CiudadRequest extends FormRequest
{


    protected $redirectRoute = 'editCiudad';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['ciudad'] = strtoupper(trim($attributes['ciudad']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'ciudad' => ['required','min:2',new Uppercase,'unique:ciudades,ciudad,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'ciudad.required' => 'El :attribute requiere por lo menos de 2 caracteres',
            'ciudad.unique' => 'La :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'ciudad' => 'Ciudad',
        ];
    }

    public function manage()
    {

        $Item = [
            'ciudad' => strtoupper($this->ciudad),
        ];

        try {
            if ($this->id == 0) {
                $item = Ciudad::create($Item);
            } else {
                $item = Ciudad::find($this->id);
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
            return $url->route('newCiudad');
        }
    }







}
