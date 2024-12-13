<?php


namespace App\Models\Denuncias;

//use App\Filters\Catalogo\ServicioFilter;
//use App\Traits\Catalogos\Estructura\Servicio\ServicioTrait;
use App\Filters\Denuncia\DenunciaAmbitoFilter;
use App\Filters\Denuncia\DenunciaFilter;
use App\Filters\Denuncia\GetDenunciasAmbitoItemCustomFilter;
use App\Filters\Denuncia\GetDenunciasItemCustomFilter;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Origen;
use App\Models\Catalogos\Prioridad;
use App\Models\Catalogos\Servicio;
use App\Traits\Denuncia\DenunciaTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class _viDDSs extends Model{

//    use SoftDeletes;
    use DenunciaTrait;

    protected $guard_name = 'web';
    protected $table = '_viddss';

    protected $fillable = [
        'id','uuid','ciudadano','curp_ciudadano','ap_paterno_ciudadano','ap_materno_ciudadano','nombre_ciudadano',
        'fecha_ingreso','dependencia_ultimo_estatus','area','subarea','servicio_ultimo_estatus','cp',
        'telefonoscelularesemails', 'calle','num_ext','num_int','colonia','ubicacion','ambito_dependencia',
        'denuncia','referencia', 'status_denuncia','prioridad','origen','observaciones','genero','genero_ciudadano',
        'cerrado','origen_id','ciudadano_id','ultimo_estatus','firmado','latitud','longitud',
        'clave_identificadora','estatus_general','ambito','ambito_sas','ue_id',
    ];

    public function scopeFilterBy($query, $filters){
        return (new DenunciaFilter())->applyTo($query, $filters);
    }
    public function scopeGetDenunciasItemCustomFilter($query, $filters){
        return (new GetDenunciasItemCustomFilter())->applyTo($query, $filters);
    }

    public function scopeAmbitoFilterBy($query, $filters){
        return (new DenunciaAmbitoFilter())->applyTo($query, $filters);
    }
    public function scopeGetDenunciasAmbitoItemCustomFilter($query, $filters){
        return (new GetDenunciasAmbitoItemCustomFilter())->applyTo($query, $filters);
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
        return $this->belongsToMany(User::class,'denuncia_modificadopor','denuncia_id','modificadopor_id');
    }

    public function respuesta(){
        return $this->hasOne(Respuesta::class,'id','respuesta_id');
    }

    public function respuestas(){
        return $this->belongsToMany(Respuesta::class,'denuncia_respuesta','denuncia_id','respuesta_id');
    }

    public function imagene(){
        return $this->hasOne(Imagene::class,'id','imagene_id');
    }

    public function imagenes(){
        return $this->belongsToMany(Imagene::class,'denuncia_imagene','denuncia_id','imagene_id');
    }

//    public function user(){
//        return $this->hasOne(User::class,'id','user_id');
//    }
//
//    public function users(){
//        return $this->belongsToMany(User::class,'denuncia_user','denuncia_id','user_id');
//    }
//
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
        return $this->hasOne(Servicio::class,'id','due_id');
    }







}
