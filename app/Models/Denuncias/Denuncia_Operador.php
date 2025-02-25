<?php

namespace App\Models\Denuncias;

use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Servicio;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Denuncia_Operador extends Model{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'denuncia_operador';

    protected $fillable = [
        'id',
        'denuncia_id', 'operador_id','orden','observaciones',
    ];

    protected $hidden = ['deleted_at','created_at','updated_at'];
    protected $casts = ['cerrada'=>'boolean','predeterminado'=>'boolean',];
    protected $dates = ['fecha_asignacion' => 'datetime:d-m-Y','fecha_ejecucion' => 'datetime:d-m-Y'];


    public function denuncia(){
        return $this->hasOne(Denuncia::class,'id','denuncia_id');
    }

    public function operador(){
        return $this->hasOne(User::class,'id','operador_id');
    }

    public function isCerrada(){
        return $this->cerrada;
    }

    public function isActivo(){
        return $this->predeterminado;
    }


}
