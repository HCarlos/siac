<?php

namespace App\Models\Users;

use App\Filters\User\CategoriaFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'categorias';

    protected $fillable = [
        'id','categoria',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function scopeFilterBy($query, $filters){
        return (new CategoriaFilter())->applyTo($query, $filters);
    }

    public static function findOrImport($categoria){
        $obj = static::where('categoria', $categoria)->first();
        if (!$obj) {
            $obj = static::create([
                'categoria' => strtoupper($categoria),
                ]);
        }
        return $obj;
    }

}
