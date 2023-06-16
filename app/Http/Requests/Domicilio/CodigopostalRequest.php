<?php

namespace App\Http\Requests\Domicilio;

use App\Models\Catalogos\Domicilios\Codigopostal;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Uppercase;
use App\Classes\MessageAlertClass;
use Illuminate\Database\QueryException;

class CodigopostalRequest extends FormRequest
{


    protected $redirectRoute = 'editCodigopostal';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['codigo'] = strtoupper(trim($attributes['codigo']));
        $attributes['cp'] = strtoupper(trim($attributes['cp']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'codigo' => ['required','min:2','max:6'],
            'cp' => ['required','min:2','max:6',new Uppercase(),'unique:codigospostales,cp,'.$this->id],
        ];
    }

    public function manage()
    {
        $Item = [
            'codigo' => strtoupper($this->codigo),
            'cp' => strtoupper($this->cp),
        ];

        try {
            if ($this->id == 0) {
                $item = Codigopostal::create($Item);
            } else {
                $item = Codigopostal::find($this->id);
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
            return $url->route('newCodigopostal');
        }
    }





}
