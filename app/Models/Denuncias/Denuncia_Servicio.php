<?php

namespace App\Models\Denuncias;

use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Servicio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Denuncia_Servicio extends Model{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'denuncia_servicio';

    protected $fillable = [
        'id',
        'denuncia_id', 'servicio_id',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function denuncia(){
        return $this->hasOne(Denuncia::class,'id','denuncia_id');
    }

    public function servicio(){
        return $this->hasOne(Servicio::class,'id','servicio_id');
    }

}
