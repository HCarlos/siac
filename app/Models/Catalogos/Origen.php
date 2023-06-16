<?php

namespace App\Models\Catalogos;

use App\Filters\Catalogo\OrigenFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Origen extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'origenes';

    protected $fillable = [
        'id', 'origen',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    protected $casts = ['predeterminado'=>'boolean',];

    public function isDefault(){
        return $this->predeterminado;
    }

    public function scopeFilterBy($query, $filters){
        return (new OrigenFilter())->applyTo($query, $filters);
    }

    public static function findOrImport($origen){
        $obj = static::where('origen', trim($origen))->first();
        if (!$obj) {
            $obj = static::create([
                'origen' => strtoupper(trim($origen)),
            ]);
        }
        return $obj;
    }


}
