<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia;

use App\Classes\MessageAlertClass;
use App\Events\DenunciaUpdateStatusGeneralAmbitoEvent;
use App\Events\IUQDenunciaEvent;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Controllers\Storage\StorageDenunciaAmbitoController;
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
use Illuminate\Support\Facades\Redirect;

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
            'descripcion'         => ['required','string','min:4'],
            'servicio_id'         => ['required','numeric','min:1'],
            'usuario_id'          => ['required','numeric','min:1'],
            'origen_id'           => ['required','numeric','min:1'],
            'ubicacion_id'        => ['required','numeric','min:1'],
            'latitud'             => ['required','numeric'],
            'longitud'            => ['required','numeric'],
            'gd_ubicacion'        => ['required','string','min:4'],
            'centro_localidad_id' => ['required','numeric','gt:0'],
        ];
    }

    public function messages(){
        return [
            'descripcion.required'   => 'La :attribute requiere por lo menos de 4 caracter',
        ];
    }

    public function attributes(){
        return [
            'descripcion'         => 'Solicitud',
            'servicio_id'         => 'Servicio',
            'origen_id'           => 'Fuente',
            'usuario_id'          => 'Usuario',
            'ubicacion_id'        => 'Ubicación',
            'latitud'             => 'Latitud',
            'longitud'            => 'Longitud',
            'gd_ubicacion'        => 'Ubicación google',
            'centro_localidad_id' => 'Localidad',
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

            $IsObs = isset($this->observaciones) ? strtoupper(trim($this->observaciones)) : "SE RECIBE LA SOLICITUD";
            $this->observaciones = $IsObs;
            $isEstatus = isset($this->estatus_id) ? (int) $this->estatus_id : env('ESTATUS_DEFAULT_SERVICIOS_MUNICIPALES');
            $this->estatus_id = $isEstatus;
            $isHashTag = isset($this->clave_identificadora) ? strtoupper($this->clave_identificadora) : '';
            $this->clave_identificadora = $isHashTag;

            $Item = [
                'fecha_ingreso'                => $this->fecha_ingreso ?? $fi,
                'oficio_envio'                 => is_null($this->oficio_envio) ? "" : strtoupper(trim($this->oficio_envio)),
                'folio_sas'                    => is_null($this->folio_sas) ? "" : strtoupper(trim($this->folio_sas)),
                'fecha_oficio_dependencia'     => $this->fecha_oficio_dependencia ?? $fecha_i,
                'fecha_ejecucion'              => $this->fecha_ejecucion ?? $fecha->addDay(3)->format('Y-m-d'),
                'fecha_limite'                 => $this->fecha_limite ?? $fecha->addDay(3)->format('Y-m-d'),
                'descripcion'                  => isset($this->descripcion) ? strtoupper(trim($this->descripcion)) : '',
                'referencia'                   => isset($this->referencia) ? strtoupper(trim($this->referencia)) : '',
                'clave_identificadora'         => $this->clave_identificadora,
                'calle'                        => strtoupper(trim($Ubicacion->calle)),
                'num_ext'                      => strtoupper(trim($Ubicacion->num_ext)),
                'num_int'                      => strtoupper(trim($Ubicacion->num_int)),
                'colonia'                      => strtoupper(trim($Ubicacion->colonia)),
                'comunidad'                    => strtoupper(trim($Ubicacion->comunidad)),
                'ciudad'                       => strtoupper(trim($Ubicacion->ciudad)),
                'municipio'                    => strtoupper(trim($Ubicacion->municipio)),
                'estado'                       => strtoupper(trim($Ubicacion->estado)),
                'cp'                           => strtoupper(trim($Ubicacion->cp)),
                'latitud'                      => $this->latitud ?? 0.0000,
                'longitud'                     => $this->longitud ?? 0.0000,
                'altitud'                      => $this->altitud ?? 0.0000,
                'search_google'                => $this->search_google ?? '',
                'gd_ubicacion'                 => $this->gd_ubicacion ?? '',
                'codigo_postal_manual'         => $this->codigo_postal_manual ?? '',
                'search_google_select'         => $this->search_google_select ?? '',
                'prioridad_id'                 => $this->prioridad_id ?? 2,
                'origen_id'                    => $this->origen_id ?? 1,
                'dependencia_id'               => $Servicio->dependencia_id,
                'ubicacion_id'                 => $this->ubicacion_id,
                'servicio_id'                  => $this->servicio_id,
                'estatus_id'                   => $this->estatus_id,
                'ciudadano_id'                 => $this->usuario_id,
                'creadopor_id'                 => $this->creadopor_id,
                'modificadopor_id'             => $this->modificadopor_id,
                'domicilio_ciudadano_internet' => strtoupper(trim($this->domicilio_ciudadano_internet))  ?? '' ,
                'observaciones'                => $this->observaciones,
                'ip'                           => FuncionesController::getIp(),
                'host'                         => config('atemun.public_url'),
                'ambito'                       => $this->ambito ?? 0,
                'centro_localidad_id'          => $this->centro_localidad_id ?? 0,
            ];


            if (Auth::user()->isRole('Administrator|SysOp')){
                $item = $this->guardar($Item);
            }elseif ( Auth::user()->isRole('ENLACE|DELEGADOS|COORDINACION_DE_DELEGADOS|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN') ){
                if (auth()->user()->hasAnyPermission(['all','guardar_expediente','modificar_expediente'])) {
                    $item = $this->guardar($Item);
                }else {
                    return null;
                }
            }else{
                return null;
            }
        }catch (Exception $e){
            $Msg = new MessageAlertClass();
            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }
        return $item;

    }

    protected function guardar($Item){
        $trigger_type = 0;
        $user_id = Auth::user()->id;

//        dd($this->id);
        if ((int)$this->id === 0) {
            $item = Denuncia::create($Item);
            $this->attaches($item, null, null);
            event(new DenunciaUpdateStatusGeneralAmbitoEvent($item->id,$user_id,$trigger_type));
        } else {
            $item = Denuncia::find($this->id);
            $item_viejito = Denuncia::find($this->id);
            if ($item->cerrado === false){
                $this->detaches($item);
                $item->update($Item);
                $this->attaches($item, $item_viejito, $Item);
                $trigger_type = 1;
                event(new DenunciaUpdateStatusGeneralAmbitoEvent($item->id,$user_id,$trigger_type));
            }
        }
        if ($item->cerrado == false) {
            if ( $this->files->keys() !== null ) {
                $Storage = new StorageDenunciaAmbitoController();
                $Storage->subirArchivoDenunciaAmbito($this, $item);
            }
            if ( $this->scannerInputs !== null ) {
                $Storage = new StorageDenunciaAmbitoController();
                $Storage->subirArchivoDenunciaAmbitoBase64($this, $item);
            }
        }
        event(new IUQDenunciaEvent($item->id,Auth::user()->id,$trigger_type));
//        $this->sendMailToEnlace($trigger_type);

        return $item;

    }

    public function attaches($Item, $item_viejito, $item_nuevo){
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
                $Objx = $Item->dependencias()->attach($Item->dependencia_id,
                    [
                        'servicio_id'      => $Item->servicio_id,
                        'estatu_id'        => $Item->estatus_id,
                        'favorable'        => false,
                        'fecha_movimiento' => now(),
                        'creadopor_id'     => $user_id,
                        'observaciones'    => $Item->observaciones
                    ]);
            }

            // Buscamos en denuncia_ubicacion
            $Obj = DB::table('denuncia_ubicacion')
                ->where('denuncia_id','=',$Item->id)
                ->where('ubicacion_id','=',$Item->ubicacion_id)
                ->get();
            if ( $Obj->count() <= 0 ) {
                $Obj = $Item->ubicaciones()->attach($Item->ubicacion_id);
                $ubic = Ubicacion::find($Item->ubicacion_id);
                $ubic->update([
                    'altitud' => $Item->altitud ?? 0.00,
                    'search_google' => $Item->search_google ?? '',
                    'g_ubicacion' => $Item->gd_ubicacion ?? '']);
            }

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
                ->where('ciudadano_id','=',$Item->ciudadano_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->ciudadanos()->attach($Item->ciudadano_id);

            // Buscamos en creadopor_denuncia
            $Obj = DB::table('creadopor_denuncia')
                ->where('denuncia_id','=',$Item->id)
                ->where('creadopor_id','=',$Item->creadopor_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->creadospor()->attach($Item->creadopor_id);

            // Buscamos en denuncia_modificadopor
            $arrMod = FuncionesController::loQueSeModifico($Item, $item_viejito, $item_nuevo);
            if ($arrMod['campos_modificados'] !== '' && $arrMod['antes'] !== '' && $arrMod['despues'] !== '') {
                $Obj = $Item->modificadospor()->attach($Item->modificadopor_id,[
                    'campos_modificados' => $arrMod['campos_modificados'],
                    'antes'              => $arrMod['antes'],
                    'despues'            => $arrMod['despues']
                ]);
            }

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

//        $Item->modificadospor()->detach($this->modificadopor_id);


        return $Item;
    }

    protected function addUserDenuncia($Item){
        $item = Denuncia::find($this->id);
        if ($item->cerrado === false){
            $Item->ciudadanos()->detach($this->usuario_id);
            $Item->ciudadanos()->attach($this->usuario_id);
        }
        return $item;
    }



    public function getRedirectUrl(){
        //        return Redirect::to('editDenunciaAmbito/'.$this->ambito_dependencia.'/'.$item->id);

        $url = $this->redirector->getUrlGenerator();
        if ($this->id > 0){
            return $url->route($this->redirectRoute,['ambito_dependencia'=>$this->ambito_dependencia,'Id'=>$this->id]);
        }else{
            return $url->route('newDenunciaAmbito',['ambito_dependencia' => $this->ambito_dependencia,'ambito_estatus' => 0] );
        }
    }







}
