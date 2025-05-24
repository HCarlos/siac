<?php
/**
 * Copyright (c) 2019. Realizado por Carlos Hidalgo
 */

namespace App\Models\Denuncias;

use App\Classes\Denuncia\ActualizaEstadisticasARO;
use App\Filters\Denuncia\Count\DenunciaAmbitoFilterCount;
use App\Filters\Denuncia\Count\GetDenunciasAmbitoFilterCount;
use App\Filters\Denuncia\Count\GetDenunciasEstatusAmbitoFilterCount;
use App\Filters\Denuncia\Count\GetDenunciasFilterCount;
use App\Filters\Denuncia\DenunciaAmbitoFilter;
use App\Filters\Denuncia\DenunciaFilter;
use App\Filters\Denuncia\GetDenunciasAmbitoItemCustomFilter;
use App\Filters\Denuncia\GetDenunciasItemCustomFilter;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\CentroLocalidad;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Origen;
use App\Models\Catalogos\Prioridad;
use App\Models\Catalogos\Servicio;
use App\Traits\Denuncia\DenunciaTrait;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Denuncia extends Model
{
    use SoftDeletes;
    use DenunciaTrait;

    protected $guard_name = 'web';
    protected $table = 'denuncias';

    protected $fillable = [
        'id','cantidad', 'oficio_envio',
        'descripcion', 'referencia', 'clave_identificadora', 'domicilio_ciudadano_internet', 'observaciones',
        'calle','num_ext','num_int','colonia', 'comunidad','ciudad','municipio','estado','pais', 'cp',
        'latitud','longitud','altitud',
        'prioridad_id','origen_id','dependencia_id','ubicacion_id','servicio_id','estatus_id',
        'fecha_ingreso', 'fecha_oficio_dependencia', 'fecha_limite', 'fecha_ejecucion',
        'ciudadano_id','creadopor_id','created_at','modificadopor_id','updated_at','deleted_at',
        'searchtextdenuncia', 'denunciamobile_id',
        'folio_sas','favorable','estatus_general','status_denuncia',
        'cerrado','fecha_cerrado','cerradopor_id','firmado','uuid',
        'ip', 'host','ambito',
        'ue_id','due_id','sue_id','fecha_ultimo_estatus',
        'search_google','gd_ubicacion','centro_localidad_id',
        'dias_atendida','dias_rechazada','dias_observada',
        'codigo_postal_manual','search_google_select',
    ];
//    protected $hidden = ['deleted_at','created_at','updated_at'];
    protected $dates = ['fecha_ingreso', 'fecha_oficio_dependencia' => 'datetime:d-m-Y', 'fecha_limite' => 'datetime:d-m-Y', 'fecha_ejecucion' => 'datetime:d-m-Y', 'created_at' => 'datetime:d-m-Y H:mm:ss', 'updated_at' => 'datetime:d-m-Y H:mm:ss','fecha_cerrado'];
    protected $casts = ['cerrado'=>'boolean','firmado'=>'boolean','favorable'=>'boolean',];

    public function scopeSearch($query, $search){
        if (!$search || $search == "" || $search == null) return $query;

            $search = strtoupper($search);
            $filters  = $search;
            $F        = new FuncionesController();
            $tsString = $F->string_to_tsQuery( strtoupper($filters),' & ');
            return $query
                ->where('status_denuncia', 1)
                ->whereRaw("searchtextdenuncia @@ to_tsquery('spanish', ?)", [$tsString])
                ->orderByRaw("calle, num_ext, num_int, colonia, descripcion, referencia ASC");
    }
//->orderByRaw("ts_rank(searchtextdenuncia, to_tsquery('spanish', ?)) DESC", [$search]);

    public function scopeFilterBy($query, $filters){
//        dd($filters);
        return (new DenunciaFilter())->applyTo($query, $filters);
    }

    public function scopeGetDenunciasItemCustomFilter($query, $filters){
//        dd("1");
        return (new GetDenunciasItemCustomFilter())->applyTo($query, $filters);
    }

    public function scopeGetDenunciasFilterCount($query, $filters){
//        dd("2");
        return (new GetDenunciasFilterCount())->applyTo($query, $filters);
    }

    public function scopeAmbitoFilterBy($query, $filters){
        return (new DenunciaAmbitoFilter())->applyTo($query, $filters);
    }
    public function scopeGetDenunciasAmbitoItemCustomFilter($query, $filters){
//        dd("3");
        return (new GetDenunciasAmbitoItemCustomFilter())->applyTo($query, $filters);
    }
    public function scopeGetDenunciasAmbitoFilterCount($query, $filters){
//        dd("4");
        return (new GetDenunciasAmbitoFilterCount())->applyTo($query, $filters);
    }

    public function scopeFilterByCount($query, $filters){
//        dd("4--");
        return (new DenunciaAmbitoFilterCount())->applyTo($query, $filters);
    }
    public function scopeGetDenunciasEstatusAmbitoFilterCount($query, $filters){
//        dd("5");
        return (new GetDenunciasEstatusAmbitoFilterCount())->applyTo($query, $filters);
    }

    public function prioridad(){
        return $this->hasOne(Prioridad::class,'id','prioridad_id');
    }

    public function prioridades(){
        return $this->belongsToMany(Prioridad::class,'denuncia_prioridad','denuncia_id','prioridad_id');
    }

    public function origen(){
        return $this->hasOne(Origen::class,'id','origen_id');
    }

    public function origenes(){
        return $this->belongsToMany(Origen::class,'denuncia_origen','denuncia_id','origen_id');
    }

    public function estatu(){
        return $this->hasOne(Estatu::class,'id','estatus_id');
    }

    public function estatus(){
        return $this->belongsToMany(Estatu::class,'denuncia_estatu','denuncia_id','estatus_id');
    }

    public function dependencia(){
        return $this->hasOne(Dependencia::class,'id','dependencia_id');
    }

    public function dependencias(){
        return $this->belongsToMany(Dependencia::class,'denuncia_dependencia_servicio_estatus','denuncia_id','dependencia_id')
            ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida','creadopor_id');
    }

    public function denuncia_dependencias(){
        return $this->belongsToMany(Dependencia::class,'denuncia_dependencia_servicio_estatus','denuncia_id','dependencia_id')
            ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida','creadopor_id');
    }

    public function denuncia_servicios(){
        return $this->belongsToMany(Servicio::class,'denuncia_dependencia_servicio_estatus','denuncia_id','servicio_id')
        ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida','creadopor_id');
    }

    public function denuncia_estatus(){
        return $this->belongsToMany(Estatu::class,'denuncia_dependencia_servicio_estatus','denuncia_id','estatu_id')
            ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida','creadopor_id');
    }

    public function ubicacion(){
        return $this->hasOne(Ubicacion::class,'id','ubicacion_id');
    }

    public function UbicacMe(){
        return $this->hasOne(Ubicacion::class,'id','ubicacion_id');
    }

    public function ubicaciones(){
        return $this->belongsToMany(Ubicacion::class,'denuncia_ubicacion','denuncia_id','ubicacion_id');
    }

    public function servicio(){
        return $this->hasOne(Servicio::class,'id','servicio_id');
    }

    public function servicios(){
        return $this->belongsToMany(Servicio::class,'denuncia_servicio','denuncia_id','servicio_id');
    }

    public function ciudadano(){
        return $this->hasOne(User::class,'id','ciudadano_id');
    }
    public function ciudadanos(){
        return $this->belongsToMany(User::class,'ciudadano_denuncia','denuncia_id','ciudadano_id');
    }

    public function creadopor(){
        return $this->hasOne(User::class,'id','creadopor_id');
    }
    public function creadospor(){
        return $this->belongsToMany(User::class,'creadopor_denuncia','denuncia_id','creadopor_id');
    }

    public function modificadopor(){
        return $this->hasOne(User::class,'id','modificadopor_id');
    }
    public function modificadospor(){
        return $this->belongsToMany(User::class,'denuncia_modificadopor','denuncia_id','modificadopor_id')
            ->withPivot( 'campos_modificados','antes','despues');
    }

    public function denuncia_modificado(){
        return $this->hasMany(Denuncia_Modificado::class,'denuncia_id','id');
    }



    public function respuesta(){
        return $this->hasOne(Respuesta::class,'id','respuesta_id');
    }

    public function respuestas(){
        return $this->belongsToMany(Respuesta::class,'denuncia_respuesta','denuncia_id','respuesta_id');
    }

    public function operadores(){
        return $this->belongsToMany(User::class,'denuncia_operador','denuncia_id','operador_id');
    }

    public function imagene(){
        return $this->hasOne(Imagene::class,'id','imagene_id');
    }

    public function imagenes(){
        return $this->belongsToMany(Imagene::class,'denuncia_imagene','denuncia_id','imagene_id');
    }

    public function firma(){
        return $this->hasOne(Firma::class,'id','firma_id');
    }

    public function firmas(){
        return $this->belongsToMany(Firma::class,'denuncia_firma','denuncia_id','firma_id');
    }

    public function cerradopor(){
        return $this->hasOne(User::class,'id','cerradopor_id');
    }

    public function ultimo_estatu_denuncia_dependencia_servicio(){
        return $this->hasMany(Denuncia_Dependencia_Servicio::class,'denuncia_id','id');
    }

    public function ultimo_estatus(){
        return $this->hasOne(Estatu::class,'id','ue_id');
    }

    public function dependencia_ultimo_estatus(){
        return $this->hasOne(Dependencia::class,'id','due_id');
    }

    public function servicio_ultimo_estatus(){
        return $this->hasOne(Servicio::class,'id','sue_id');
    }

    public function semaforo_ultimo_estatus(){

        return ActualizaEstadisticasARO::semaforo_ultimo_estatus_off($this->ue_id, new DateTime($this->fecha_ultimo_estatus), $this->fecha_ingreso);

    }

    public function getLocalidadCentroAttribute(){
        $ret = [];
        if ($this->centro_localidad_id > 0) {
            return CentroLocalidad::find($this->centro_localidad_id);
        }
    }

    public function scopeHasEstatuDependencia():array{
        $arr      = Auth::user()->DependenciaIdArray;
        $dds = Denuncia_Dependencia_Servicio::where('denuncia_id', $this->id)->whereIn('dependencia_id', $arr)->orderBy('id', 'DESC')->first();
        if ($dds){
            return [$dds->dependencia_id, $dds->servicio_id, $dds->estatu_id, $dds->observaciones];
        }
        return [0,0,0,''];

    }



}
