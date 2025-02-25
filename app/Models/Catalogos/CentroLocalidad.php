<?php

namespace App\Models\Catalogos;

use App\Filters\Catalogo\ServicioCategoriaFilter;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CentroLocalidad extends Model{


    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'centro_localidades';

    protected $fillable = [
        'id', 'consecutivo',
        'zona_id','zona',
        'delegacion_id','prefijo_delegacion','delegacion',
        'colonia_id','prefijo_colonia','colonia',
        'delegado_id',
    ];

    protected $casts = ['activo'=>'boolean',];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function isActivo(){
        return $this->activo;
    }

    public function delegado(){
        return $this->hasOne(User::class,'id','delegado_id');
    }

}
