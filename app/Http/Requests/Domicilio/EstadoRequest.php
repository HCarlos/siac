<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Domicilio;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Domicilios\Estado;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;

class EstadoRequest extends FormRequest
{


    protected $redirectRoute = 'editEstado';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'estado' => ['required','min:2',new Uppercase,'unique:estados,estado,'.$this->id],
        ];
    }

    public function manage()
    {
        $Item = [
            'estado' => strtoupper($this->estado),
        ];

        try {
            if ($this->id == 0) {
                $item = Estado::create($Item);
            } else {
                $item = Estado::find($this->id);
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
            return $url->route('newEstado');
        }
    }





}
