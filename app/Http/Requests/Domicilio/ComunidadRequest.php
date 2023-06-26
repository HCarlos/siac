<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Domicilio;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ComunidadRequest extends FormRequest
{


    protected $redirectRoute = 'editComunidad';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['comunidad'] = strtoupper(trim($attributes['comunidad']));
        $this->replace($attributes);
        return parent::all();
    }

    // 'delegado_id'      => ['required','min:1','unique:comunidades,delegado_id,'.$this->id],
    public function rules()
    {
        return [
            'comunidad'        => ['required','min:2',new Uppercase,'unique:comunidades,comunidad,'.$this->id],
            'delegado_id'      => ['required','min:1'],
            'tipocomunidad_id' => ['required','min:1'],
        ];
    }

    public function manage()
    {
        //dd($this->all());


        try {
            //$ciudad_id = $this->ciudad_id;
            $Item = [
                'comunidad'        => strtoupper($this->comunidad),
                'nomenclatura'     => strtoupper($this->nomenclatura),
                'tipocomunidad_id' => $this->tipocomunidad_id,
                'delegado_id'      => $this->delegado_id,
                'ciudad_id'        => $this->ciudad_id,
                'municipio_id'     => $this->municipio_id,
                'estado_id'        => $this->estado_id,
                'ambito_comunidad' => trim($this->ambito_comunidad),
            ];

            if ($this->id == 0) {
                $item = Comunidad::create($Item);
            } else {
                $item = Comunidad::find($this->id);
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
            return $url->route('newComunidad');
        }
    }



}
