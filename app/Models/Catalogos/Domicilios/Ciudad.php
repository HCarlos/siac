<?php

namespace App\Models\Catalogos\Domicilios;

use App\Filters\Catalogo\Domicilio\CiudadFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ciudad extends Model
{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'ciudades';

    protected $fillable = [
        'id', 'ciudad', 'ciudad_mig_id', 'municipio_id','estatus_cve',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function scopeSearch($query, $search){
        if (!$search || $search == "" || $search == null) return $query;
        return $query->whereRaw("searchtextciudad @@ to_tsquery('spanish', ?)", [$search])
            ->orderByRaw("ts_rank(searchtextciudad, to_tsquery('spanish', ?)) ASC", [$search]);
    }

    public function scopeFilterBy($query, $filters){
        return (new CiudadFilter())->applyTo($query, $filters);
    }

    public static function findOrImport($ciudad){
        $obj = static::where('ciudad', trim($ciudad))->first();
        if (!$obj) {
            $obj = static::create([
                'ciudad' => strtoupper(trim($ciudad)),
            ]);
        }
        return $obj;
    }


}
