<?php

namespace App\Models\Catalogos;

use App\Filters\Catalogo\Dependencia\DependenciaFilter;
use App\Models\Denuncias\Denuncia;
use App\Traits\Catalogos\DependenciaTraits;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dependencia extends Model
{
    use SoftDeletes;
    use DependenciaTraits;

    protected $guard_name = 'web';
    protected $table = 'dependencias';

    protected $fillable = [
        'id', 'dependencia', 'abreviatura','class_css','visible_internet','is_areas','jefe_id','user_id','orden_impresion',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];
    protected $casts = ['visible_internet'=>'boolean','is_areas'=>'boolean',];

    public function scopeFilterBy($query, $filters){
        return (new DependenciaFilter())->applyTo($query, $filters);
    }

    public function jefe() {
//        return $this->belongsTo(User::class,'jefe_id','id');
        return $this->hasOne(User::class,'id','jefe_id');
    }

    public function estatu(){
        return $this->hasOne(Estatu::class,'id','jefe_id');
    }

    public function estatus(){
        return $this->belongsToMany(Estatu::class);
    }

    public function enlaces(){
        return $this->belongsToMany(User::class);
    }
    public function denuncia(){
        return $this->hasOne(Denuncia::class,'id','denuncia_id');
    }

    public function denuncias(){
        return $this->belongsToMany(Denuncia::class,'denuncia_dependencia_servicio_estatus','dependencia_id','denuncia_id')
        ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida');
    }

    public function servicios(){
        return $this->belongsToMany(Servicio::class,'denuncia_dependencia_servicio_estatus','dependencia_id','servicio_id')
        ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida');
    }

    public function dependencia_estatus(){
        return $this->belongsToMany(Estatu::class,'denuncia_dependencia_servicio_estatus','dependencia_id','estatu_id')
        ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida');
    }

    public function isVisibleInternet(){
        return $this->visible_internet;
    }

    public function isArea(){
        return $this->is_areas;
    }

    public static function findOrImport($dependencia,$abreviatura,$class_css,$visible_internet,$is_areas,$jefe_id,$user_id){
        $obj = static::where('dependencia', trim($dependencia))->first();
        if (!$obj) {
            $obj = static::create([
                'dependencia' => strtoupper(trim($dependencia)),
                'abreviatura' => strtoupper(trim($abreviatura)),
                'class_css' => $class_css,
                'visible_internet' => $visible_internet,
                'is_areas' => $is_areas,
                'jefe_id' => $jefe_id,
                'user_id' => $user_id,
            ]);
        }
//        $jefe = User::find($jefe_id);
//        $obj->Jefe()->create($jefe);
        return $obj;
    }


}
