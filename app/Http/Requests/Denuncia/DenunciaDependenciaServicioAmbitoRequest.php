<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia;

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Classes\MessageAlertClass;
use App\Classes\NotificationsMobile\SendNotificationFCM;
use App\Events\ChangeStatusEvent;
use App\Events\DenunciaAtendidaEvent;
use App\Events\DenunciaUpdateStatusGeneralAmbitoEvent;
use App\Events\IUQDenunciaEvent;
use App\Http\Controllers\Storage\StorageRespuestaDenunciaController;
use App\Models\Catalogos\Estatu;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;

class DenunciaDependenciaServicioAmbitoRequest extends FormRequest{

    protected $redirectRoute = 'editDenunciaDependenciaServicioAmbito';

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
            'observaciones'  => ['required','min:10'],
        ];
    }

    public function messages(){
        return [

            'observaciones.required'      => 'Se requieren los :attribute',
            'observaciones.min'           => 'Los :attribute requieren por lo menos 10 caracteres',
        ];
    }

    public function attributes(){
        return [
            'observaciones' => 'Argumentos',
        ];
    }

    public function manage(){
        try {
            if ( isset($this->favorable) ){
                $Fav = !( (int) $this->favorable === 0 );
            }else{
                $ambito_dependencia = Session::get('ambito_dependencia');
                if ($ambito_dependencia === 2){
                    $Est = Estatu::find($this->estatus_id);
                    $Fav = $Est->favorable;
                }else{
                    $Fav = 0;
                }
            }
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
                    'favorable'        => $Fav,
                    'fue_leida'        => false,
                    'creadopor_id'     => Auth::user()->id,
                ];
                $item = Denuncia_Dependencia_Servicio::findOrFail($this->id);
                $item->update($Item);
                event(new ChangeStatusEvent($item->denuncia_id,$this->estatus_id,$item->id,1));
                return $this->sendInfo($item);

            }
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return $Msg->Message($e);
        }
        return $this->id;
    }

    public function attaches($Item){

       $item =  (object) [
            'denuncia_id' => $this->denuncia_id,
            'respuesta'    => $this->observaciones ?? '',
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

        $it = Denuncia_Dependencia_Servicio::query()
            ->where('denuncia_id',$Item->id)
            ->where('dependencia_id',$this->dependencia_id)
            ->where('servicio_id',$this->servicio_id)
            ->where('estatu_id',$this->estatus_id)
            ->orderByDesc('id')->first();

        event(new ChangeStatusEvent($Item->id,$this->estatus_id,$it->id,0));

        return $this->sendInfo($it);

    }


    function saveImage($item){
        if ($this->files) {
            $Storage = new StorageRespuestaDenunciaController();
            $Storage->subirArchivoDenunciaRespuesta($this, Denuncia::find($this->denuncia_id),$item);
        }
    }


    function sendInfo($item){

        $this->saveImage($item);

        $vid = new VistaDenunciaClass();
        $vid->vistaDenuncia($this->denuncia_id);

        event(new DenunciaUpdateStatusGeneralAmbitoEvent($this->denuncia_id,Auth::user()->id,3));

        $cfm = new SendNotificationFCM();
        $cfm->sendNotificationMobile($item,3);

        event(new DenunciaAtendidaEvent($this->denuncia_id,Auth::user()->id,1,$this->estatus_id, true, null));

        return Denuncia_Dependencia_Servicio::orderBy('id', 'DESC')->first()->id;

    }

    protected function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('addDenunciaDependenciaServicioAmbito',['Id'=>$this->denuncia_id]);
        }
    }











}
