<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia;

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Classes\MessageAlertClass;
use App\Classes\NotificationsMobile\SendNotificationFCM;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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


    public function manage(){
        try {
            if ( $this->id <= 0 ){
                $item = Denuncia::find($this->denuncia_id);
                $this->attaches($item);
            }else{
                $Item = [
                    'dependencia_id'   => $this->dependencia_id,
                    'servicio_id'      => $this->servicio_id,
                    'estatu_id'        => $this->estatus_id,
                    'fecha_movimiento' => now(),
                    'observaciones'    => $this->observaciones,
                    'favorable'        => !( (int) $this->favorable == 0 ),
                    'fue_leida'        => false,
                    'creadopor_id'     => Auth::user()->id,
                ];
                $item = Denuncia_Dependencia_Servicio::findOrFail($this->id);
                $item->update($Item);

                $vid = new VistaDenunciaClass();
                $vid->vistaDenuncia($this->denuncia_id);

            }
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return $Msg->Message($e);
        }
        return $this->id;

    }

    public function attaches($Item){
        //dd($Item);
        $item =  (object) [
            'denuncia_id' => $this->denuncia_id,
            'respuesta'    => $this->observaciones,
        ];

        $Item->dependencias()->attach(
            $this->dependencia_id,
            [
                'servicio_id'      => $this->servicio_id,
                'estatu_id'        => $this->estatus_id,
                'fecha_movimiento' => now(),
                'observaciones'    => $this->observaciones,
                'favorable'        => !( (int)$this->favorable == 0 ),
                'fue_leida'        => false,
                'creadopor_id'     => Auth::user()->id,
            ]
        );
        $cfm = new SendNotificationFCM();
        $cfm->sendNotificationMobile($item,3);

        $vid = new VistaDenunciaClass();
        $vid->vistaDenuncia($this->denuncia_id);

        return Denuncia_Dependencia_Servicio::orderBy('id', 'DESC')->first()->id;

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
