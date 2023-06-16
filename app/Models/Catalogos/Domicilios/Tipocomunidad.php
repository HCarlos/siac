<?php

namespace App\Models\Catalogos\Domicilios;

use App\Filters\Catalogo\Domicilio\TipocomunidadFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipocomunidad extends Model
{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'tipocomunidades';

    protected $fillable = [
        'id', 'tipocomunidad','nomenclatura',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function scopeFilterBy($query,$filters){
        return (new TipocomunidadFilter())->applyTo($query, $filters);
    }

    public static function findOrImport($tipocomunidad){
        $obj = static::where('tipocomunidad', $tipocomunidad)->first();
        if (!$obj) {
            $obj = static::create([
                'tipocomunidad' => strtoupper($tipocomunidad),
            ]);
        }
        return $obj;
    }


}
