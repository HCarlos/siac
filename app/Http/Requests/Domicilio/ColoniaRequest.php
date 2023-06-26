<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Domicilio;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Domicilios\Codigopostal;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ColoniaRequest extends FormRequest
{


    protected $redirectRoute = 'editColonia';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['colonia'] = strtoupper(trim($attributes['colonia']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'colonia'         => ['required','min:2',new Uppercase,'unique:colonias,colonia,'.$this->id],
            'codigopostal_id' => ['required','numeric','min:1'],
            'comunidad_id'    => ['required','numeric','min:1'],
        ];
    }

    public function manage()
    {

        try {

            $CPs       = Codigopostal::findOrFail($this->codigopostal_id);
            $Comunidad = Comunidad::findOrFail($this->comunidad_id);
            $Item = [
                'colonia'          => strtoupper(trim($this->colonia)),
                'nomenclatura'     => strtoupper(trim($this->nomenclatura)),
                'altitud'          => $this->altitud ?? 0.00,
                'latitud'          => $this->latitud ?? 0.00,
                'longitud'         => $this->longitud ?? 0.00,
                'codigopostal_id'  => $this->codigopostal_id,
                'cp'               => $CPs->cp,
                'comunidad_id'     => $this->comunidad_id,
                'tipocomunidad_id' => $Comunidad->tipocomunidad_id,
            ];

//            dd($Item);


            if ($this->id == 0) {
                $item = Colonia::create($Item);
            } else {
                $item = Colonia::find($this->id);
                $item->update($Item);
                Ubicacion::detachesColonia($this->id);
                $this->detaches($item);
            }
            $this->attaches($item);
            Ubicacion::attachesColonia($this->id);
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
            return $url->route('newColonia');
        }
    }


    public function attaches($Item){
        $Item->codigospostales()->attach($this->codigopostal_id);
        $Item->comunidades()->attach($this->comunidad_id);
        $Item->tipocomunidades()->attach($Item->tipocomunidad_id);
        return $Item;
    }

    public function detaches($Item){
        $Item->codigospostales()->detach($Item->codigopostal_id);
        $Item->comunidades()->detach($Item->comunidad_id);
        $Item->tipocomunidades()->detach($Item->tipocomunidad_id);
        return $Item;
    }






}
