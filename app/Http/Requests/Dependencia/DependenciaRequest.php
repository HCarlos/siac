<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Dependencia;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Dependencia;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DependenciaRequest extends FormRequest
{

    protected $redirectRoute = 'editDependencia';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['dependencia'] = strtoupper(trim($attributes['dependencia']));
        $attributes['abreviatura'] = strtoupper(trim($attributes['abreviatura']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'dependencia' => ['required','min:2',new Uppercase,'unique:dependencias,dependencia,'.$this->id],
            'abreviatura' => ['required','min:2',new Uppercase,'max:10','unique:dependencias,abreviatura,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'dependencia.required' => 'La :attribute requiere por lo menos de 2 caracteres',
            'dependencia.unique' => 'La :attribute ya existe',
            'abreviatura.required' => 'La :attribute requiere por lo menos de 2 caracteres',
            'abreviatura.unique' => 'La :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'dependencia' => 'Dependencia',
            'abreviatura' => 'Abreviatura',
        ];
    }

    public function manage()
    {

        $Item = [
            'dependencia' => strtoupper($this->dependencia),
            'abreviatura' => strtoupper($this->abreviatura),
            'class_css' => $this->class_css,
            'visible_internet' => $this->visible_internet==1?true:false,
            'is_areas' => $this->is_areas==1?true:false,
            'jefe_id' => $this->jefe_id,
            'user_id' => 1,
        ];

//        dd($Item);

        try {

            if ($this->id == 0) {
                $item = Dependencia::create($Item);
//                $jefe = User::find($this->jefe_id);
//                $item->Jefe()->create($jefe);

            } else {
                $item = Dependencia::find($this->id);
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
            return $url->route('newDependencia');
        }
    }





}
