<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia;

use App\Classes\MessageAlertClass;
use App\Models\Catalogos\Estatu;
use App\Observers\Catalogos\Estatu\PostUpdating;
use App\Rules\Uppercase;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StatuRequest extends FormRequest
{


    protected $redirectRoute = 'editEstatu';

    public function authorize(){
        return true;
    }


    public function validationData(){
        $attributes = parent::all();
        $attributes['estatus'] = strtoupper(trim($attributes['estatus']));
        if (!Auth::user()->isRole('Administrator')){
            $attributes['estatus'] = $attributes['estatus'] == "CERRADO" ? "CERRADO_XXXXXX" : $attributes['estatus'];
            $this->replace($attributes);
        }
        return parent::all();
    }

    public function rules()
    {
        return [
            'estatus' => ['required','min:3','unique:estatus,estatus,'.$this->id],
        ];
    }
//'dependencia_id' => ['present','not_in:0','gt:0'],

    public function messages()
    {
        return [
            'estatus.required' => 'El :attribute requiere por lo menos de 3 caracter',
            'estatus.unique' => 'El :attribute ya existe',
            'dependencia_id.not_in' => 'Indique una :attribute',
            'dependencia_id.gt' => 'El valor de :attribute debe ser mayor a CERO.',
        ];
    }

    public function attributes()
    {
        return [
            'estatus' => 'Estatus',
            'dependencia_id' => 'Dependencia',
        ];
    }

    public function manage(){

        try {

            if ( isset($this->favorable) ){
                $Fav = !( (int) $this->favorable === 0 );
            }else{
                $Fav = false;
            }

            $Item = [
                'estatus' => strtoupper($this->estatus),
                'predeterminado'  => $this->predeterminado==1 ? true : false,
                'resuelto'        => $this->resuelto==1 ? true : false,
                'abreviatura'     => strtoupper($this->abreviatura),
                'orden_impresion' => strtoupper($this->orden_impresion),
                'estatus_cve'     => (int) ($this->estatus_cve),
                'favorable'       => $Fav,
                'ambito_estatus'  => $this->ambito_estatus,
                'requiere_imagen' => $this->requiere_imagen==1 ? true : false,
            ];

//            dd($Item);

            if ( $this->predeterminado == 1) {
                Estatu::where('predeterminado',true)
                    ->where('ambito_estatus',$this->ambito_estatus)
                    ->update(['predeterminado'=>false]);
            };

            $idd = $this->dependencia_id;
            $isExsit = Estatu::whereHas('dependencias', function ($q) use ($idd) {
                return $q->where("dependencia_id",$idd);
            })->first();

//            dd($isExsit);
            if ($this->id == 0) {
                $item = Estatu::create($Item);
                if ($this->dependencia_id > 0 && $isExsit <= 0 ){
                    $item->dependencias()->attach($this->dependencia_id);
                }
            } else {
                $item = Estatu::find($this->id);
                $item->update($Item);
                if ($this->dependencia_id > 0 && $isExsit <= 0 ){
                    $item->dependencias()->attach($this->dependencia_id);
                    PostUpdating::updating($item);
                }
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
            return $url->route('newEstatu');
        }
    }


}
