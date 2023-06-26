<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Dependencia;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Area;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AreaRequest extends FormRequest
{

    protected $redirectRoute = 'editArea';

    public function authorize(){
        return true;
    }


    public function validationData(){
        $attributes = parent::all();
        $attributes['area'] = strtoupper(trim($attributes['area']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'area' => ['required','min:2',new Uppercase],
        ];
//        'area' => ['required','min:2',new Uppercase,'unique:areas,area,'.$this->id],
    }

    public function messages()
    {
        return [
            'area.required' => 'La :attribute requiere por lo menos de 2 caracteres',
        ];
//        'area.unique' => 'La :attribute ya existe',
    }

    public function attributes()
    {
        return [
            'area' => 'Area',
        ];
    }

    public function manage()
    {

        $Item = [
            'area' => strtoupper($this->area),
            'dependencia_id' => $this->dependencia_id,
            'jefe_id' => $this->jefe_id,
        ];

        try {

            if ($this->id == 0) {
                $item = Area::create($Item);
                $item->dependencias()->attach($this->dependencia_id);
                $item->jefes()->attach($this->jefe_id);
            } else {
                $item = Area::find($this->id);
                $item->update($Item);
            }
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }
//        dd($item);
        return $item;
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('newArea');
        }
    }


}
