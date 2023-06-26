<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Dependencia;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Subarea;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubareaRequest extends FormRequest
{


    protected $redirectRoute = 'editSubarea';

    public function authorize()
    {
        return true;
    }


    public function validationData(){
        $attributes = parent::all();
        $attributes['subarea'] = strtoupper(trim($attributes['subarea']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'subarea' => ['required','min:2'],
        ];
    }

    public function messages()
    {
        return [
            'subarea.required' => 'La :attribute requiere por lo menos de 2 caracteres',
        ];
    }

    public function attributes()
    {
        return [
            'subarea' => 'Subarea',
        ];
    }

    public function manage()
    {

        $Item = [
            'subarea' => strtoupper($this->subarea),
            'area_id' => $this->area_id,
            'jefe_id' => $this->jefe_id,
        ];

        try {

            if ($this->id == 0) {
                $item = Subarea::create($Item);
                $item->areas()->attach($this->area_id);
                $item->jefes()->attach($this->jefe_id);

            } else {
                $item = Subarea::find($this->id);
                $item->areas()->detach($item->area_id);
                $item->jefes()->detach($item->jefe_id);

                $item->areas()->attach($this->area_id);
                $item->jefes()->attach($this->jefe_id);

                $item->update($Item);
            }
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            throw new HttpResponseException(response()->json( $e, 422));
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
            return $url->route('newSubarea');
        }
    }



}
