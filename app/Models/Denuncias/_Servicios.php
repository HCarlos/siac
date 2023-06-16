<?php

namespace App\Models\Denuncias;

use App\Filters\Catalogo\ServicioFilter;
use App\Traits\Catalogos\Estructura\Servicio\ServicioTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class _Servicios extends Model{

    use ServicioTrait;

    protected $guard_name = 'web';
    protected $table = '_viservicios';

    public function scopeFilterBy($query, $filters){
        return (new ServicioFilter())->applyTo($query, $filters);
    }

}
