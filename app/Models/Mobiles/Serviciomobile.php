<?php
/*
 * Copyright (c) 2022. Realizado por Carlos Hidalgo
 */

namespace App\Models\Mobiles;

use App\Models\Catalogos\Area;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Servicio;
use App\Models\Catalogos\Subarea;
use App\Traits\Catalogos\Estructura\Servicio\ServicioTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serviciomobile extends Model{

    use SoftDeletes;
    use ServicioTrait;

    protected $guard_name = 'web';
    protected $table = 'serviciomobile';

    protected $fillable = [
        'id', 'servicio','url_image_mobile', 'orden_image_mobile', 'subarea_id','area_id','dependencia_id','servicio_id',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];
    protected $casts = ['habilitado'=>'boolean','is_visible_mobile'=>'boolean',];

    public function IsEnabled(){
        return $this->habilitado;
    }

    public function IsVisibleMobile(){
        return $this->is_visible_mobile;
    }

    public function subarea() {
        return $this->hasOne(Subarea::class,'id','subarea_id');
    }

    public function area() {
        return $this->hasOne(Area::class,'id','area_id');
    }
    public function Dependencia() {
        return $this->hasOne(Dependencia::class,'id','dependencia_id');
    }

    public function Servicio() {
        return $this->hasOne(Servicio::class,'id','servicio_id');
    }



}
