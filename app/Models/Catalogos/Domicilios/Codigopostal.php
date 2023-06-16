<?php

namespace App\Models\Catalogos\Domicilios;

use App\Filters\Catalogo\Domicilio\CodigopostalFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Codigopostal extends Model
{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'codigospostales';

    protected $fillable = [
        'id', 'codigo', 'cp', 'cp_mig_id',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function scopeFilterBy($query, $filters){
        return (new CodigopostalFilter())->applyTo($query, $filters);
    }

    public static function findOrImport($codigo,$cp){
        $obj = static::where('codigo', trim($codigo))->first();
        if (!$obj) {
            $obj = static::create([
                'codigo' => strtoupper($codigo),
                'cp' => strtoupper($cp),
            ]);
        }
        return $obj;
    }



}
