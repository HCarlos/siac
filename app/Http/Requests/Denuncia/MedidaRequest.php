<?php

namespace App\Http\Requests\Denuncia;

use App\Models\Catalogos\Medida;
use App\Rules\Uppercase;
use Illuminate\Foundation\Http\FormRequest;
use App\Classes\MessageAlertClass;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;

class MedidaRequest extends FormRequest
{


    protected $redirectRoute = 'editMedida';

    public function authorize()
    {
        return true;
    }


    public function validationData(){
        $attributes = parent::all();
        $attributes['medida'] = strtoupper(trim($attributes['medida']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'medida' => ['required','min:2',new Uppercase,'unique:medidas,medida,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'medida.required' => 'El :attribute requiere por lo menos de 2 caracter',
            'medida.unique' => 'El :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'medida' => 'Medida',
        ];
    }

    public function manage()
    {

        $Item = [
            'medida' => strtoupper($this->medida),
        ];

        try {

            if ($this->id == 0) {
                $item = Medida::create($Item);
            } else {
                $item = Medida::find($this->id);
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
            return $url->route('newMedida');
        }
    }




}
