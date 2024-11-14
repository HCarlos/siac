<?php

namespace App\Models\Catalogos;

use App\Filters\Catalogo\PrioridadFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prioridad extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'prioridades';

    protected $fillable = [
        'id', 'prioridad','predeterminado', 'class_css','estatus_cve',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];
    protected $casts = ['predeterminado'=>'boolean',];

    public function scopeFilterBy($query, $filters){
        return (new PrioridadFilter())->applyTo($query, $filters);
    }

    public function isDefault(){
        return $this->predeterminado;
    }

    public static function findOrImport($prioridad,$predeterminado,$class_css){
        $obj = static::where('prioridad', trim($prioridad))->first();
        if (!$obj) {
            $obj = static::create([
                'prioridad' => strtoupper(trim($prioridad)),
                'predeterminado' => $predeterminado,
                'class_css' => $class_css,
            ]);
        }
        return $obj;
    }




}
