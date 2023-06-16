<?php

namespace App\Models\Catalogos;

use App\Filters\Catalogo\Dependencia\AreaFilter;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'areas';

    protected $fillable = [
        'id',
        'area', 'dependencia_id','jefe_id','abreviatura','orden_impresion',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function scopeFilterBy($query, $filters){
        return (new AreaFilter())->applyTo($query, $filters);
    }

    public function jefe() {
        return $this->belongsTo(User::class,'jefe_id','id');
    }

    public function jefes() {
        return $this->belongsToMany(User::class,'area_jefe','area_id','jefe_id');
    }

    public function dependencia() {
        return $this->hasOne(Dependencia::class,'id','dependencia_id');
    }

    public function dependencias() {
        return $this->belongsToMany(Dependencia::class,'area_dependencia','area_id','dependencia_id');
    }

    public function subarea() {
        return $this->hasOne(Subarea::class,'id','subarea_id');
    }

    public function subareas() {
        return $this->belongsToMany(Subarea::class,'area_subarea','area_id','subarea_id');
    }

    public static function findOrImport($area,$dependencia_id,$jefe_id){
        $obj = static::where('area', trim($area))->first();
        if (!$obj) {
            $obj = static::create([
                'area' => strtoupper(trim($area)),
                'dependencia_id' => $dependencia_id,
                'jefe_id' => $jefe_id,
            ]);
            if ($obj->id > 0){
                $obj->dependencias()->attach($dependencia_id);
                $obj->jefes()->attach($jefe_id);
            }
        }
        return $obj;
    }


}
