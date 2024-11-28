<?php

namespace App\Models\Catalogos;

use App\Filters\Catalogo\ServicioCategoriaFilter;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioCategoria extends Model{


    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'servicioscategorias';

    protected $fillable = [
        'id', 'categoria_servicios','enlaces_unidades','predeterminado',
    ];

    protected $casts = ['predeterminado'=>'boolean',];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function scopeFilterBy($query, $filters){
        return (new ServicioCategoriaFilter())->applyTo($query, $filters);
    }

    public function isDefault(){
        return $this->predeterminado;
    }

    public function users(){
        return $this->belongsToMany(User::class,'servicioscategoria_user','servicioscategoria_id','user_id')
            ->withPivot('orden','predeterminado');
    }

}
