<?php

namespace App\Models\Catalogos\Domicilios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pais extends Model
{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'paises';

    protected $fillable = [
        'id', 'pais',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public static function findOrImport($pais){
        $obj = static::where('pais', $pais)->first();
        if (!$obj) {
            $obj = static::create([
                'pais' => strtoupper($pais),
            ]);
        }
        return $obj;
    }



}
