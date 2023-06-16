<?php

namespace App\Http\Requests\Denuncia;

use App\Classes\MessageAlertClass;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;

class DenunciaDependenciaServicioRequest extends FormRequest
{



    protected $redirectRoute = 'editDenunciaDependenciaServicio';

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'dependencia_id' => ['required'],
            'servicio_id'    => ['required'],
            'estatus_id'     => ['required'],
        ];
    }


    public function manage()
    {
        try {

            if ( $this->id <= 0 ){

               //dd( $this->denuncia_id );
                $item = Denuncia::find($this->denuncia_id);
                $this->attaches($item);
            }else{
                $Item = [
                    'dependencia_id'   => $this->dependencia_id,
                    'servicio_id'      => $this->servicio_id,
                    'estatu_id'        => $this->estatus_id,
                    'fecha_movimiento' => now(),
                    'observaciones'    => $this->observaciones,
                    'favorable'        => !(intval($this->favorable) == 0),
                ];
                $item = Denuncia_Dependencia_Servicio::findOrFail($this->id);
                $item->update($Item);
            }
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return $Msg->Message($e);
        }
        return $this->id;

    }

    public function attaches($Item){
        //dd($Item);
        $Item->dependencias()->attach(
            $this->dependencia_id,
            [
                'servicio_id'      => $this->servicio_id,
                'estatu_id'        => $this->estatus_id,
                'fecha_movimiento' => now(),
                'observaciones'    => $this->observaciones,
                'favorable'        => !(intval($this->favorable) == 0),
            ]
        );
        $It = Denuncia_Dependencia_Servicio::orderBy('id', 'DESC')->first()->id;
        $this->id = $It;
        return $this->id;
    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('addDenunciaDependenciaServicio');
        }
    }











}
