<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia;

use App\Classes\MessageAlertClass;
use App\Events\DenunciaUpdateStatusGeneralEvent;
use App\Events\IUQDenunciaEvent;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Controllers\Storage\StorageDenunciaController;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Denuncias\_viServicios;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\DenunciaEstatu;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DenunciaAmbitoRequest extends FormRequest
{


    protected $redirectRoute = 'editDenunciaAmbito';

    public function validationData(){
        $attributes = parent::all();
        $IsEnlace =Auth::user()->isRole('ENLACE');
        $DependenciaArray = '';
        IF ($IsEnlace) {
            $DependenciaIdArray = Auth::user()->DependenciaIdArray;
        }
        $this->replace($attributes);
        return parent::all();
    }


    public function authorize(){
        return true;
    }

    public function rules()
    {

        return [
            'descripcion'      => ['required'],
            'servicio_id'      => ['required'],
            'usuario_id'       => ['required'],
            'ubicacion_id'     => ['required','numeric','min:1'],
        ];
    }

    public function messages(){
        return [
            'descripcion.required'   => 'La :attribute requiere por lo menos de 4 caracter',
        ];
    }

    public function attributes(){
        return [
            'descripcion'     => 'Solicitud',
            'referencia'      => 'Referencia',
            'servicio_id'     => 'Servicio',
            'usuario_id'      => 'Usuario',
            'ubicacion_id'    => 'Ubicación',
        ];
    }

    public function manage($ambito_dependencia){
        try {
            $Ubicacion = Ubicacion::findOrFail($this->ubicacion_id);
            $Servicio  = _viServicios::findOrFail($this->servicio_id);

            $fecha = Carbon::now();
//            $fecha_i = date('Y-m-d',strtotime($this->fecha_ingreso));
            $fecha_i = $fecha->format('Y-m-d');
            $fecha_f = date('H:i:s');
            $fecha_f = $fecha->format('H:i:s');

            $fi = $fecha_i.' '.$fecha_f;

            $Item = [
                'fecha_ingreso'                => $this->fecha_ingreso ?? $fi,
                'oficio_envio'                 => is_null($this->oficio_envio) ? "" : strtoupper($this->oficio_envio),
                'folio_sas'                    => is_null($this->folio_sas) ? "" : strtoupper($this->folio_sas),
                'fecha_oficio_dependencia'     => $this->fecha_oficio_dependencia ?? $fecha_i,
                'fecha_ejecucion'              => $this->fecha_ejecucion ?? $fecha->addDay(3)->format('Y-m-d'),
                'fecha_limite'                 => $this->fecha_limite ?? $fecha->addDay(3)->format('Y-m-d'),
                'descripcion'                  => isset($this->descripcion) ? strtoupper($this->descripcion) : '',
                'referencia'                   => isset($this->referencia) ? strtoupper($this->referencia) : '',
                'clave_identificadora'         => isset($this->clave_identificadora) ? strtoupper($this->clave_identificadora) : '',
                'calle'                        => strtoupper($Ubicacion->calle),
                'num_ext'                      => strtoupper($Ubicacion->num_ext),
                'num_int'                      => strtoupper($Ubicacion->num_int),
                'colonia'                      => strtoupper($Ubicacion->colonia),
                'comunidad'                    => strtoupper($Ubicacion->comunidad),
                'ciudad'                       => strtoupper($Ubicacion->ciudad),
                'municipio'                    => strtoupper($Ubicacion->municipio),
                'estado'                       => strtoupper($Ubicacion->estado),
                'cp'                           => strtoupper($Ubicacion->cp),
                'latitud'                      => $this->latitud ?? 0.0000,
                'longitud'                     => $this->longitud ?? 0.0000,
                'prioridad_id'                 => $this->prioridad_id ?? 2,
                'origen_id'                    => $this->origen_id ?? 1,
                'dependencia_id'               => $Servicio->dependencia_id,
                'ubicacion_id'                 => (int)$this->ubicacion_id,
                'servicio_id'                  => (int)$this->servicio_id,
                'estatus_id'                   => isset($this->estatus_id) ? (int) $this->estatus_id : 8,
                'ciudadano_id'                 => (int)$this->usuario_id,
                'creadopor_id'                 => (int)$this->creadopor_id,
                'modificadopor_id'             => (int)$this->modificadopor_id,
                'domicilio_ciudadano_internet' => strtoupper(trim($this->domicilio_ciudadano_internet))  ?? '' ,
                'observaciones'                => isset($this->observaciones) ? strtoupper(trim($this->observaciones)) : "",
                'ip'                           => FuncionesController::getIp(),
                'host'                         => config('atemun.public_url'),
                'ambito'                       => $this->ambito ?? 0,
            ];

//            dd($Item);

            if (Auth::user()->isRole('Administrator|SysOp')){
                $item = $this->guardar($Item);
            }elseif ( Auth::user()->isRole('ENLACE|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN') ){
                if (auth()->user()->hasAnyPermission(['all','guardar_expediente','modificar_expediente'])) {
                    $item = $this->guardar($Item);
                }else {
                    return null;
                }
            }else{
                return null;
            }
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }
        return $item;

    }

    protected function guardar($Item){
        $trigger_type = 0;
        if ($this->id == 0) {
            $item = Denuncia::create($Item);
            $this->attaches($item);
        } else {
            $item = Denuncia::find($this->id);
            if ($item->cerrado == false){
                $this->detaches($item);
                $item->update($Item);
                $this->attaches($item);
                $trigger_type = 1;
            }
        }
        if ($item->cerrado == false) {
            $Storage = new StorageDenunciaController();
            $Storage->subirArchivoDenuncia($this, $item);
        }
        event(new IUQDenunciaEvent($item->id,Auth::user()->id,$trigger_type));
        return $item;
    }

    public function attaches($Item){
        try {
            $user_id = Auth::user()->id;
            $trigger_type = 0;
            if ($Item->id === 1) {
                $trigger_type = 1;
            }

            // Buscamos en denuncia_prioridad
            $Obj = DB::table('denuncia_prioridad')
                ->where('denuncia_id','=',$Item->id)
                ->where('prioridad_id','=',$Item->prioridad_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->prioridades()->attach($Item->prioridad_id);

            // Buscamos en denuncia_origen
            $Obj = DB::table('denuncia_origen')
                ->where('denuncia_id','=',$Item->id)
                ->where('origen_id','=',$Item->origen_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->origenes()->attach($Item->origen_id);

            // Buscamos en denuncia_dependencia_servicio_estatus
            $Obj = DB::table('denuncia_dependencia_servicio_estatus')
                ->where('denuncia_id','=',$Item->id)
                ->where('dependencia_id','=',$Item->dependencia_id)
                ->where('servicio_id','=',$Item->servicio_id)
                ->where('estatu_id','=',$Item->estatus_id)
                ->get();
            if ($Obj->count() <= 0 ) {
                $Objx = $Item->dependencias()->attach($Item->dependencia_id, ['servicio_id' => $Item->servicio_id, 'estatu_id' => $Item->estatus_id, 'favorable' => false, 'fecha_movimiento' => now(), 'creadopor_id' => $user_id]);
                event(new DenunciaUpdateStatusGeneralEvent($Item->id,$user_id,$trigger_type));
            }

            // Buscamos en denuncia_ubicacion
            $Obj = DB::table('denuncia_ubicacion')
                ->where('denuncia_id','=',$Item->id)
                ->where('ubicacion_id','=',$Item->ubicacion_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->ubicaciones()->attach($Item->ubicacion_id);

            // Buscamos en denuncia_servicio
            $Obj = DB::table('denuncia_servicio')
                ->where('denuncia_id','=',$Item->id)
                ->where('servicio_id','=',$Item->servicio_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->servicios()->attach($Item->servicio_id);

            // Buscamos en denuncia_dependencia_servicio_estatus
            $Obj = DB::table('denuncia_dependencia_servicio_estatus')
                ->where('denuncia_id','=',$Item->id)
                ->where('dependencia_id','=',$Item->dependencia_id)
                ->where('servicio_id','=',$Item->servicio_id)
                ->where('estatu_id','=',$Item->estatus_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->estatus()->attach($Item->estatus_id,['ultimo'=>true]);

            // Buscamos en ciudadano_denuncia
            $Obj = DB::table('ciudadano_denuncia')
                ->where('denuncia_id','=',$Item->id)
                ->where('ciudadano_id','=',$Item->usuario_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->ciudadanos()->attach($Item->usuario_id);

            // Buscamos en creadopor_denuncia
            $Obj = DB::table('creadopor_denuncia')
                ->where('denuncia_id','=',$Item->id)
                ->where('creadopor_id','=',$Item->creadopor_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->creadospor()->attach($Item->creadopor_id);

            // Buscamos en denuncia_modificadopor
            $Obj = DB::table('denuncia_modificadopor')
                ->where('denuncia_id','=',$Item->id)
                ->where('modificadopor_id','=',$Item->modificadopor_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->modificadospor()->attach($Item->modificadopor_id);

        }catch (Exception $e){
            return $e->getMessage();
        }
        return $Item;
    }

    public function detaches($Item){
        $user_id = Auth::user()->id;
        $trigger_type = 0;
        if ($Item->id === 1) {
            $trigger_type = 1;
        }


        $Item->prioridades()->detach($this->prioridad_id);
        $Item->origenes()->detach($this->origen_id);

        $Item->ubicaciones()->detach($this->ubicacion_id);

        DenunciaEstatu::where('denuncia_id',$this->id)->orderByDesc('id')->update(['ultimo'=>true]);
        $Item->ciudadanos()->detach($this->usuario_id);
        $Item->creadospor()->detach($this->creadopor_id);
        $Item->modificadospor()->detach($this->modificadopor_id);

        event(new DenunciaUpdateStatusGeneralEvent($Item->id,$user_id,$trigger_type));

        return $Item;
    }

    protected function addUserDenuncia($Item){
        $item = Denuncia::find($this->id);
        if ($item->cerrado == false){
            $Item->ciudadanos()->detach($this->usuario_id);
            $Item->ciudadanos()->attach($this->usuario_id);
        }
        return $item;
    }




    public function getRedirectUrl()
    {
        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['Id'=>$this->id]);
        }else{
            return $url->route('newDenunciaAmbito');
        }
    }







}