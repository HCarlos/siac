<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia;

use App\Events\DenunciaUpdateStatusGeneralAmbitoEvent;
use App\Events\IUQDenunciaEvent;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Controllers\Storage\StorageDenunciaAmbitoController;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\_viServicios;
use App\Models\Denuncias\Denuncia;
use App\User;
use Doctrine\DBAL\Driver\Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DenunciaKioskoRequest extends FormRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'descripcion'         => ['string', 'min:4', 'max:255', 'required'],
            'servicio_id'         => ['required', 'numeric', 'exists:servicios,id'],
            'user_id'            => ['required', 'exists:users,id'],
            'search_google'       => ['required', 'string'], // Cambiado a string
            'centro_localidad_id' => ['required', 'numeric', 'gt:0'],
        ];
    }

    public function attributes(){
        return [
            'descripcion'         => 'Solicitud',
            'servicio_id'         => 'Servicio',
            'username'            => 'Usuario',
            'search_google'       => 'Calle y número',
            'centro_localidad_id' => 'Localidad',
        ];
    }

    public function manage(){
        try {
            // Obtener usuario con fallback controlado
            $usuario = $this->getUser();

//            dd($usuario);

            // Obtener recursos necesarios
            $ubicacion = $this->getUbicacion();
            $servicio = $this->getServicio();

            // Preparar datos para la denuncia
            $denunciaData = $this->prepareDenunciaData($usuario, $ubicacion, $servicio);

            // Guardar la denuncia con manejo de permisos
            $item = $this->saveDenunciaWithPermissions($denunciaData);

            return $item;

        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function getUser(){
        return User::find($this->user_id) ?? User::findOrFail(519130);
    }

    protected function getUbicacion(){
        return Ubicacion::findOrFail(279663); // ID fijo según tu lógica
    }

    protected function getServicio(){
        return _viServicios::find($this->servicio_id);
    }

    protected function prepareDenunciaData($usuario, $ubicacion, $servicio){

//        dd($servicio->dependencia_id);

        $now = now();
        $fechaEjecucion = $now->copy()->addDays(3);

        return [
            'fecha_ingreso'                => $this->fecha_ingreso ?? $now->format('Y-m-d H:i:s'),
            'oficio_envio'                 => strtoupper(trim($this->oficio_envio ?? '')),
            'folio_sas'                    => strtoupper(trim($this->folio_sas ?? '')),
            'fecha_oficio_dependencia'     => $this->fecha_oficio_dependencia ?? $now->format('Y-m-d'),
            'fecha_ejecucion'              => $this->fecha_ejecucion ?? $fechaEjecucion->format('Y-m-d'),
            'fecha_limite'                 => $this->fecha_limite ?? $fechaEjecucion->format('Y-m-d'),
            'descripcion'                  => strtoupper(trim($this->descripcion)),
            'referencia'                   => strtoupper(trim($this->referencia ?? '')),
            'clave_identificadora'         => strtoupper($this->clave_identificadora ?? ''),
            'calle'                        => strtoupper(trim($ubicacion->calle)),
            'num_ext'                      => strtoupper(trim($ubicacion->num_ext)),
            'num_int'                      => strtoupper(trim($ubicacion->num_int)),
            'colonia'                      => strtoupper(trim($ubicacion->colonia)),
            'comunidad'                    => strtoupper(trim($ubicacion->comunidad)),
            'ciudad'                       => strtoupper(trim($ubicacion->ciudad)),
            'municipio'                    => strtoupper(trim($ubicacion->municipio)),
            'estado'                       => strtoupper(trim($ubicacion->estado)),
            'cp'                           => strtoupper(trim($ubicacion->cp)),
            'latitud'                      => $this->latitud ?? 17.998887170641467,
            'longitud'                     => $this->longitud ?? -92.94474352674484,
            'altitud'                      => $this->altitud ?? 0.0000,
            'search_google'                => $this->search_google,
            'gd_ubicacion'                 => $this->gd_ubicacion ?? '',
            'codigo_postal_manual'         => $this->codigo_postal_manual ?? '',
            'search_google_select'         => $this->search_google_select ?? '',
            'prioridad_id'                 => $this->prioridad_id ?? 2,
            'origen_id'                    => $this->origen_id ?? 26,
            'dependencia_id'               => $servicio->dependencia_id,
            'ubicacion_id'                 => $ubicacion->id,
            'servicio_id'                  => $servicio->id,
            'estatus_id'                   => $this->estatus_id ?? 16,
            'ciudadano_id'                 => $usuario->id,
            'creadopor_id'                 => $usuario->id,
            'modificadopor_id'             => $usuario->id,
            'domicilio_ciudadano_internet' => strtoupper(trim($this->domicilio_ciudadano_internet ?? '')),
            'observaciones'                => $this->observaciones ?? 'SE RECIBE LA SOLICITUD',
            'ip'                           => request()->ip(),
            'host'                         => config('app.url'),
            'ambito'                       => 2,
            'centro_localidad_id'          => $this->centro_localidad_id,
        ];
    }

    protected function saveDenunciaWithPermissions(array $itemData){
        $user = $this->getUser();
        $permission = 'guardar_expediente';

        if ( !$user->isRole('Administrator|SysOp') ) {
            if (!$user->isRole('ENLACE|DELEGADOS|COORDINACION_DE_DELEGADOS|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN') ||
                !$user->hasAnyPermission(['all', $permission, 'modificar_expediente'])) {
                throw new AuthorizationException('No tiene permisos para realizar esta acción');
            }
    }

        return $this->guardar($itemData);
    }

    protected function guardar(array $itemData){
//        DB::beginTransaction();

        try {
            $trigger_type = 0;
            $user_id = $this->getUser()->id;

            if (empty($this->id)) {
                $item = Denuncia::create($itemData);
                $this->attaches($item, null, null);
                event(new DenunciaUpdateStatusGeneralAmbitoEvent($item->id, $user_id, $trigger_type));
            } else {
                $item = Denuncia::findOrFail($this->id);

                $item_viejito = clone $item;
                $item->update($itemData);
                $this->attaches($item, $item_viejito, $itemData);
                $trigger_type = 1;
                event(new DenunciaUpdateStatusGeneralAmbitoEvent($item->id, $user_id, $trigger_type));
            }

            $this->handleFiles($item);

            event(new IUQDenunciaEvent($item->id, $user_id, $trigger_type));

            return $item;

        } catch (\Exception $e) {
            //DB::rollBack();
            throw $e;
        }
    }

    protected function handleFiles($item){
        if (!$item->cerrado) {
            $storage = new StorageDenunciaAmbitoController();

            if ($this->files->keys() !== null) {
                $storage->subirArchivoDenunciaAmbito($this, $item);
            }

            if ($this->scannerInputs !== null) {
                $storage->subirArchivoDenunciaAmbitoBase64($this, $item);
            }
        }
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
            return $e->getMessage();
        }
        return $Item;
    }


    public function handleException(\Exception $e){
        $status = 500;
        $message = 'Error interno del servidor';

        if ($e instanceof ModelNotFoundException) {
            $status = 404;
            $message = 'Recurso no encontrado';
        } elseif ($e instanceof AuthorizationException) {
            $status = 403;
            $message = $e->getMessage();
        } elseif ($e instanceof ValidationException) {
            $status = 422;
            $message = $e->getMessage();
        }

        return response()->json([
            'message' => $message,
            'error' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => config('app.debug') ? $e->getTrace() : []
        ], $status);
    }

}
