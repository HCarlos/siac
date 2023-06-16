<?php

namespace App\Models\Catalogos\Domicilios;

use App\Filters\Catalogo\Domicilio\TipoasentamientoFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipoasentamiento extends Model
{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'tipoasentamientos';

    protected $fillable = [
        'id', 'tipoasentamiento','nomenclatura',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function scopeFilterBy($query, $filters){
        return (new TipoasentamientoFilter())->applyTo($query, $filters);
    }

    public static function findOrImport($tipoasentamiento){
        $obj = static::where('tipoasentamiento', $tipoasentamiento)->first();
        if (!$obj) {
            $obj = static::create([
                'tipoasentamiento' => strtoupper($tipoasentamiento),
            ]);
        }
        return $obj;
    }


}
