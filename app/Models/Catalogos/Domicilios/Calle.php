<?php

namespace App\Models\Catalogos\Domicilios;

use App\Filters\Catalogo\Domicilio\CalleFilter;
use App\Http\Controllers\Funciones\FuncionesController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calle extends Model
{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'calles';

    protected $fillable = [
        'id', 'calle', 'calle_mig_id','estatus_cve',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function scopeSearch($query, $search){
        if (!$search || $search == "" || $search == null) return $query;
            $search = strtoupper($search);
            $filters  = $search;
            $F        = new FuncionesController();
            $tsString = $F->string_to_tsQuery( strtoupper($filters),' & ');
            return $query->whereRaw("searchtextcalle @@ to_tsquery('spanish', ?)", [$tsString])
                ->orderByRaw("ts_rank(searchtextcalle, to_tsquery('spanish', ?)) ASC", [$tsString]);
    }


    public function scopeFilterBy($query, $filters){
        return (new CalleFilter())->applyTo($query, $filters);
    }

    public static function findOrImport($calle){
        $obj = static::where('calle', trim($calle))->first();
        if (!$obj) {
            $obj = static::create([
                'calle' => strtoupper(trim($calle)),
            ]);
        }
        return $obj;
    }



}
