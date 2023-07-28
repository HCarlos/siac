<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Domicilio;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Domicilios\Calle;
use App\Models\Catalogos\Domicilios\Codigopostal;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Ubicacion;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UbicacionRequest extends FormRequest
{


    protected $redirectRoute = 'editUbicacionV2';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'num_ext'         => ['required'],
            'num_int'         => ['present'],
            'calle_id'        => ['required'],
            'colonia_id'      => ['required'],
            ];

    }

    public function messages()
    {
        return [

            'num_ext.required'       => 'Se requiere el :attribute',
            'num_int.required'       => 'Se requiere el :attribute',
            'calle_id.required'       => 'Se requiere el :attribute',
            'colonia_id.required'       => 'Se requiere el :attribute',

        ];
    }

    public function attributes()
    {
        return [
            'num_ext'     => 'Número Exterior',
        ];
    }


    public function manage(){

        try {
//            dd( $this->all() );
            $Calle   = Calle::find($this->calle_id);
            $Colonia = Colonia::find($this->colonia_id);
            $Comunidad = Comunidad::find($Colonia->comunidad_id);
            $CPs = Codigopostal::find($Colonia->codigopostal_id);
            $Item = [
                'calle' => strtoupper($Calle->calle),
                'num_ext' => strtoupper($this->num_ext),
                'num_int' => strtoupper($this->num_int),
                'colonia' => strtoupper($Colonia->colonia),
                'comunidad' => strtoupper($Comunidad->comunidad),
                'ciudad' => strtoupper($Comunidad->ciudad->ciudad),
                'municipio' => strtoupper($Comunidad->municipio->municipio),
                'estado' => strtoupper($Comunidad->estado->estado),
                'cp' => strtoupper($CPs->cp),
                'latitud' => $this->latitud,
                'longitud' => $this->longitud,
                'calle_id' => $this->calle_id,
                'colonia_id' => $this->colonia_id,
                'comunidad_id' => $Comunidad->id,
                'ciudad_id' => $Comunidad->ciudad_id,
                'municipio_id' => $Comunidad->municipio_id,
                'estado_id' => $Comunidad->estado_id,
                'codigopostal_id' => $CPs->id,

            ];


            if ($this->id == 0) {
                $item = Ubicacion::create($Item);
            } else {
                $item = Ubicacion::find($this->id);
//                $colonia_id_actual = $this->id;
//                $comunidad_id_anterior = $item->comunidad_id;
//                $comunidad_id_actual = $Comunidad->id;

                $this->detaches($item);
                $item->update($Item);
//                if ($colonia_id_actual === $colonia_id_anterior && $comunidad_id_actual !== $comunidad_id_anterior) {
//                    Ubicacion::where('colonia_id',$comunidad_id_anterior)
//                        ->where('comunidad_id',$comunidad_id_anterior)
//                        ->update(['comunidad_id' => $comunidad_id_actual]);
//                }
            }
            $this->attaches($item);
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }
        return $item;
    }

    public function attaches($Item){
        $Item->calles()->attach($this->calle_id);
        $Item->colonias()->attach($this->colonia_id);
        $Item->comunidades()->attach($Item->comunidad_id);
        $Item->ciudades()->attach($Item->ciudad_id);
        $Item->municipios()->attach($Item->municipio_id);
        $Item->estados()->attach($Item->estado_id);
        $Item->codigospostales()->attach($Item->codigopostal_id);
        return $Item;
    }

    public function detaches($Item){
        $Item->calles()->detach($Item->calle_id);
        $Item->colonias()->detach($Item->colonia_id);
        $Item->comunidades()->detach($Item->comunidad_id);
        $Item->ciudades()->detach($Item->ciudad_id);
        $Item->municipios()->detach($Item->municipio_id);
        $Item->estados()->detach($Item->estado_id);
        $Item->codigospostales()->detach($Item->codigopostal_id);
        return $Item;
    }

    protected function getRedirectUrl(){
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('newUbicacionV2');
        }
    }





}
