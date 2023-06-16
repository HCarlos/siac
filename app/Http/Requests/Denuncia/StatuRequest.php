<?php

namespace App\Http\Requests\Denuncia;

use App\Models\Catalogos\Estatu;
use App\Observers\Catalogos\Estatu\PostUpdating;
use App\Rules\Uppercase;
use Illuminate\Foundation\Http\FormRequest;
use App\Classes\MessageAlertClass;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class StatuRequest extends FormRequest
{


    protected $redirectRoute = 'editEstatu';

    public function authorize()
    {
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
            'estatus' => ['required','min:3',new Uppercase,'unique:estatus,estatus,'.$this->id],
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

    public function manage()
    {

        try {

            $Item = [
                'estatus' => strtoupper($this->estatus),
                'predeterminado' => $this->predeterminado==1 ? true : false,
                'resuelto' => $this->resuelto==1 ? true : false,
                'abreviatura' => strtoupper($this->abreviatura),
                'orden_impresion' => strtoupper($this->orden_impresion),
                'estatus_cve' => (int) ($this->estatus_cve),
            ];

            if ( $this->predeterminado == 1) {
                Estatu::where('predeterminado',true)->update(['predeterminado'=>false]);
            };
//            return $query->whereHas('roles', function ($q) use ($roles) {
//                $q->whereIn('role_id', $roles);
//            });
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
                    $observer = PostUpdating::updating($item);
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
