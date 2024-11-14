<?php

namespace App\Models\Catalogos;

use App\Filters\Catalogo\Dependencia\SubareaFilter;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subarea extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'subareas';

    protected $fillable = [
        'id', 'subarea','area_id','jefe_id','abreviatura','orden_impresion','estatus_cve',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function scopeFilterBy($query, $filters){
        return (new SubareaFilter())->applyTo($query, $filters);
    }

    public function area() {
        return $this->hasOne(Area::class,'id','area_id');
    }

    public function areas() {
        return $this->belongsToMany(Area::class,'area_subarea','subarea_id','area_id');
    }

    public function jefe() {
        return $this->hasOne(User::class,'id','jefe_id');
    }

    public function jefes() {
        return $this->belongsToMany(User::class,'jefe_subarea','subarea_id','jefe_id');
    }

//    public function jefe() {
//        return $this->belongsTo(User::class,'jefe_id','id');
//    }

    public function dependencia() {
        return $this->hasOne(Dependencia::class,'id','dependencia_id');
    }

    public function servicio() {
        return $this->hasOne(Servicio::class,'id','servicio_id');
    }

    public function servicios() {
        return $this->hasOne(Servicio::class,'id','servicio_id');
    }

    public static function findOrImport($subarea,$area_id,$jefe_id){
        $obj = static::where('subarea', trim($subarea))->first();
        if (!$obj) {
            $obj = static::create([
                'subarea' => strtoupper(trim($subarea)),
                'area_id' => $area_id,
                'jefe_id' => $jefe_id,
            ]);
            if ($obj->id > 0) {
                $obj->areas()->attach($area_id);
                $obj->jefes()->attach($jefe_id);
            }
        }
        return $obj;
    }


}
