<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Domicilio;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Domicilios\Tipocomunidad;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TipocomunidadRequest extends FormRequest
{


    protected $redirectRoute = 'editTipocomunidad';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['tipocomunidad'] = strtoupper(trim($attributes['tipocomunidad']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'tipocomunidad' => ['required','min:2',new Uppercase(),'unique:tipocomunidades,tipocomunidad,'.$this->id],
        ];
    }

    public function manage()
    {
        $Item = [
            'tipocomunidad' => strtoupper($this->tipocomunidad),
            'nomenclatura'  => strtoupper($this->nomenclatura),
        ];

        try {
            if ($this->id == 0) {
                $item = Tipocomunidad::create($Item);
            } else {
                $item = Tipocomunidad::find($this->id);
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
            return $url->route('newTipocomunidad');
        }
    }




}
