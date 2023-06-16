<?php

namespace App\Http\Requests\Denuncia;

use App\Models\Catalogos\Afiliacion;
use App\Rules\Uppercase;
use Illuminate\Foundation\Http\FormRequest;
use App\Classes\MessageAlertClass;
use Illuminate\Database\QueryException;

class AfiliacionRequest extends FormRequest
{


    protected $redirectRoute = 'editAfiliacion';

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'afiliacion' => ['required','min:2',new Uppercase,'unique:afiliaciones,afiliacion,'.$this->id],
        ];
    }

    public function messages()
    {
        return [
            'afiliacion.required' => 'La :attribute requiere por lo menos de 2 caracteres',
            'afiliacion.unique' => 'La :attribute ya existe',
        ];
    }

    public function attributes()
    {
        return [
            'afiliacion' => 'Afiliacion',
        ];
    }

    public function manage()
    {

        $Item = [
            'afiliacion' => strtoupper($this->afiliacion),
        ];

        try {
            if ($this->predeterminado==1) {
                $items = Afiliacion::where("predeterminado",true);
                $items->update(["predeterminado" => false]);
            }
            if ($this->id == 0) {
                $item = Afiliacion::create($Item);
            } else {
                $item = Afiliacion::find($this->id);
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
            return $url->route('newAfiliacion');
        }
    }




}
