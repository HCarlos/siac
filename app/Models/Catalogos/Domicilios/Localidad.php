<?php

namespace App\Models\Catalogos\Domicilios;

use App\Filters\Catalogo\Domicilio\LocalidadFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Localidad extends Model
{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'localidades';

    protected $fillable = [
        'id', 'localidad','localidad_mig_id','estatus_cve',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function scopeSearch($query, $search){
        if (!$search || $search == "" || $search == null) return $query;
        return $query->whereRaw("searchtextlocalidad @@ to_tsquery('spanish', ?)", [$search])
            ->orderByRaw("ts_rank(searchtextlocalidad, to_tsquery('spanish', ?)) ASC", [$search]);
    }

    public function scopeFilterBy($query, $filters){
        return (new LocalidadFilter())->applyTo($query, $filters);
    }

    public static function findOrImport($localidad){
        $obj = static::where('localidad', trim($localidad))->first();
        if (!$obj && $localidad !== "") {
            $obj = static::create([
                'localidad' => strtoupper(trim($localidad)),
            ]);
        }
        return $obj;
    }


}
