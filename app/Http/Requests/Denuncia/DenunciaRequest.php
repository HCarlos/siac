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
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\DenunciaEstatu;
use Doctrine\DBAL\Driver\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DenunciaRequest extends FormRequest
{


    protected $redirectRoute = 'editDenuncia';

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
            'referencia'       => ['required'],
            'fecha_ingreso'    => ['required','date'],
            'fecha_limite'     => ['required','date'],
            'fecha_ejecucion'  => ['required','date'],
            'prioridad_id'     => ['required'],
            'origen_id'        => ['required'],
            'dependencia_id'   => ['required'],
            'servicio_id'      => ['required'],
            'usuario_id'       => ['required'],
            'ubicacion_id'     => ['required','numeric','min:1'],
            'estatus_id'       => ['required'],
        ];
    }

    public function messages(){
        return [
            'descripcion.required'   => 'La :attribute requiere por lo menos de 4 caracter',
            'referencia.required'    => 'La :attribute es requerida',
            'fecha_ingreso.required' => 'La :attribute es requerida',
        ];
    }

    public function attributes(){
        return [
            'descripcion'     => 'Denuncia',
            'referencia'      => 'Referencia',
            'fecha_ingreso'   => 'Fecha de Ingreso',
            'fecha_limite'    => 'Fecha Límite',
            'fecha_ejecucion' => 'Fecha de Ejecución',
            'prioridad_id'    => 'Prioridad',
            'origen_id'       => 'Origen',
            'dependencia_id'  => 'Dependencia',
            'servicio_id'     => 'Servicio',
            'usuario_id'      => 'Usuario',
            'ubicacion_id'    => 'Ubicación',
        ];
    }

    public function manage(){
        try {
            $Ubicacion = Ubicacion::findOrFail($this->ubicacion_id);

//            dd($this->dependencia_id);

            $fecha_i = date('Y-m-d',strtotime($this->fecha_ingreso));
            $fecha_f = date('H:i:s');

            $fi = $fecha_i.' '.$fecha_f;

            $Item = [
                'fecha_ingreso'                => $fi, // Carbon::now(), //Carbon::now($this->fecha_ingreso)->format('Y-m-d hh:mm:ss'),
                'oficio_envio'                 => is_null($this->oficio_envio) ? "" : strtoupper($this->oficio_envio),
                'folio_sas'                    => is_null($this->folio_sas) ? "" : strtoupper($this->folio_sas),
                'fecha_oficio_dependencia'     => $this->fecha_oficio_dependencia,
                'fecha_limite'                 => $this->fecha_limite,
                'fecha_ejecucion'              => $this->fecha_ejecucion,
                'descripcion'                  => strtoupper(trim($this->descripcion)),
                'referencia'                   => strtoupper(trim($this->referencia)),
                'clave_identificadora'         => strtoupper(trim($this->clave_identificadora)),
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
                'search_google'                => trim($this->search_google) ?? '',
                'gd_ubicacion'                 => trim($this->gd_ubicacion) ?? '',
                'prioridad_id'                 => $this->prioridad_id,
                'origen_id'                    => $this->origen_id,
                'dependencia_id'               => $this->dependencia_id,
                'ubicacion_id'                 => $this->ubicacion_id,
                'servicio_id'                  => $this->servicio_id,
                'estatus_id'                   => $this->estatus_id,
                'ciudadano_id'                 => $this->usuario_id,
                'creadopor_id'                 => $this->creadopor_id,
                'modificadopor_id'             => $this->modificadopor_id,
                'domicilio_ciudadano_internet' => strtoupper(trim($this->domicilio_ciudadano_internet))  ?? '' ,
                'observaciones'                => strtoupper(trim($this->observaciones)),
                'ip'                           => FuncionesController::getIp(),
                'host'                         => config('atemun.public_url'),
                'ambito'                       => (int) $this->ambito,
                'centro_localidad_id'          => $this->centro_localidad_id ?? null,
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
        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
//            dd($Msg->Message());
            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }
        return $item;

    }

    protected function guardar($Item){
        $trigger_type = 0;
        if ($this->id == 0) {
            $item = Denuncia::create($Item);
            $this->attaches($item, null, null);
        } else {
            $item = Denuncia::find($this->id);
            $item_viejito = Denuncia::find($this->id);
            if ($item->cerrado == false){
                $this->detaches($item);
                $item->update($Item);
//                $this->attaches($item);
                $this->attaches($item, $item_viejito, $Item);
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
                ->where('prioridad_id','=',$this->prioridad_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->prioridades()->attach($this->prioridad_id);

            // Buscamos en denuncia_origen
            $Obj = DB::table('denuncia_origen')
                ->where('denuncia_id','=',$Item->id)
                ->where('origen_id','=',$this->origen_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->origenes()->attach($this->origen_id);

            // Buscamos en denuncia_dependencia_servicio_estatus
            $Obj = DB::table('denuncia_dependencia_servicio_estatus')
                ->where('denuncia_id','=',$Item->id)
                ->where('dependencia_id','=',$this->dependencia_id)
                ->where('servicio_id','=',$this->servicio_id)
                ->where('estatu_id','=',$this->estatus_id)
                ->get();
            if ($Obj->count() <= 0 ) {
                $Objx = $Item->dependencias()->attach($this->dependencia_id, ['servicio_id' => $this->servicio_id, 'estatu_id' => $this->estatus_id, 'favorable' => false, 'fecha_movimiento' => now(), 'creadopor_id' => $user_id]);
                event(new DenunciaUpdateStatusGeneralEvent($Item->id,$user_id,$trigger_type));
            }

            // Buscamos en denuncia_ubicacion
            $Obj = DB::table('denuncia_ubicacion')
                ->where('denuncia_id','=',$Item->id)
                ->where('ubicacion_id','=',$this->ubicacion_id)
                ->get();
            if ($Obj->count() <= 0 ){
                $Obj = $Item->ubicaciones()->attach($this->ubicacion_id);
                $ubic = Ubicacion::find($Item->ubicacion_id);
                $ubic->update([
                    'altitud' => $Item->altitud ?? 0.00,
                    'search_google' => $Item->search_google ?? '',
                    'g_ubicacion' => $Item->gd_ubicacion] ?? '');
            }

            // Buscamos en denuncia_servicio
            $Obj = DB::table('denuncia_servicio')
                ->where('denuncia_id','=',$Item->id)
                ->where('servicio_id','=',$this->servicio_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->servicios()->attach($this->servicio_id);

            // Buscamos en denuncia_dependencia_servicio_estatus
            $Obj = DB::table('denuncia_dependencia_servicio_estatus')
                ->where('denuncia_id','=',$Item->id)
                ->where('dependencia_id','=',$this->dependencia_id)
                ->where('servicio_id','=',$this->servicio_id)
                ->where('estatu_id','=',$this->estatus_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->estatus()->attach($this->estatus_id,['ultimo'=>true]);

            // Buscamos en ciudadano_denuncia
            $Obj = DB::table('ciudadano_denuncia')
                ->where('denuncia_id','=',$Item->id)
                ->where('ciudadano_id','=',$this->usuario_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->ciudadanos()->attach($this->usuario_id);

            // Buscamos en creadopor_denuncia
            $Obj = DB::table('creadopor_denuncia')
                ->where('denuncia_id','=',$Item->id)
                ->where('creadopor_id','=',$this->creadopor_id)
                ->get();
            if ($Obj->count() <= 0 )
                $Obj = $Item->creadospor()->attach($this->creadopor_id);

            // Buscamos en denuncia_modificadopor

//            $Obj = DB::table('denuncia_modificadopor')
//                ->where('denuncia_id','=',$Item->id)
//                ->where('modificadopor_id','=',$this->modificadopor_id)
//                ->get();
//            if ($Obj->count() <= 0 )
//                $Obj = $Item->modificadospor()->attach($this->modificadopor_id);

            if ($item_nuevo != null) {
                $arrMod = FuncionesController::loQueSeModifico($Item, $item_viejito, $item_nuevo);
                if ($arrMod['campos_modificados'] !== '' && $arrMod['antes'] !== '' && $arrMod['despues'] !== '') {
                    $Obj = $Item->modificadospor()->attach($Item->modificadopor_id, [
                        'campos_modificados' => $arrMod['campos_modificados'],
                        'antes' => $arrMod['antes'],
                        'despues' => $arrMod['despues']
                    ]);
                }
            }

        }catch (Exception $e){

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




    public function getRedirectUrl(){

        $ambito_dependencia = Session::get('ambito_dependencia');
        $url = $this->redirector->getUrlGenerator();

        if ( isset($ambito_dependencia) ){
            if ($this->id > 0){
                return $url->route('editDenunciaAmbito',['Id'=>$this->id]);
            }else{
                return $url->route('newDenunciaAmbito',['ambito_dependencia' => $this->ambito_dependencia,'ambito_estatus' => 0] );
            }
        }else{
            if ($this->id > 0){
                return $url->route($this->redirectRoute,['Id'=>$this->id]);
            }else{
                return $url->route('newDenuncia');
            }

        }


    }







}
