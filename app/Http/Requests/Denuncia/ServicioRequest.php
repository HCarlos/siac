<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia;

use App\Classes\MessageAlertClass;
use App\Http\Controllers\Storage\Mobile\StorageMobileServicioController;
use App\Models\Catalogos\Servicio;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ServicioRequest extends FormRequest
{


    protected $redirectRoute = 'editServicio';

    public function authorize()
    {
        return true;
    }

    public function validationData(){
        $attributes = parent::all();
        $attributes['servicio'] = strtoupper(trim($attributes['servicio']));
        $this->replace($attributes);
        return parent::all();
    }

    public function rules()
    {
        return [
            'servicio' => ['required','min:2',new Uppercase,'unique:servicios,servicio,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'servicio.required' => 'La :attribute requiere por lo menos de 2 caracteres',
            'servicio.unique' => 'La :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'servicio' => 'Servicio',
        ];
    }

    public function manage(){

//        dd( $this->file('url_image_mobile') );

        $Item = [
            'servicio'                   => strtoupper($this->servicio),
            'class_css'                  => $this->class_css??'',
            'habilitado'                 => $this->habilitado==1?true:false,
            'medida_id'                  => $this->medida_id,
            'subarea_id'                 => $this->subarea_id,
            'is_visible_mobile'          => $this->is_visible_mobile==1?true:false,
            'nombre_mobile'              => $this->nombre_mobile,
            'url_image_mobile'           => $this->url_image_mobile??'',
            'orden_image_mobile'         => $this->orden_image_mobile,
            'ambito_servicio'            => trim($this->ambito_servicio),
            'nombre_corto_ss'            => trim($this->nombre_corto_ss),
            'nombre_corto_orden_ss'      => trim($this->nombre_corto_orden_ss),
            'is_visible_nombre_corto_ss' => $this->is_visible_nombre_corto_ss==1,
            'dias_ejecucion'             => (int) $this->dias_ejecucion,
            'dias_maximos_ejecucion'     => (int) $this->dias_maximos_ejecucion,
        ];

//        dd($Item);

        try {
            if ($this->id == 0) {
                $item = Servicio::create($Item);
                $item->subareas()->attach($this->subarea_id);
            } else {
                $item = Servicio::find($this->id);
                $item->update($Item);
            }
            if ( $this->file('url_image_mobile') != null) {
                $Storage = new StorageMobileServicioController();
                $Storage->subirArchivoMobileServicio($this, $item);
            }

        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
//            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }
        return $item;
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('newServicio');
        }
    }



}
