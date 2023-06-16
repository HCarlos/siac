<?php

namespace App\Models\Catalogos\Domicilios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sepomex extends Model
{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'sepomex';

    protected $fillable = [
        'id', 'zona',
        'asentamiento_id','tipoasentamiento_id','codigospostal_id','municipio_id','estado_id','ciudad_id',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function Asentamiento() {
        return $this->hasOne(Asentamiento::class,'asentamiento_id');
    }

    public function TipoAsentamiento() {
        return $this->hasOne(Tipoasentamiento::class,'tipoasentamiento_id');
    }

    public function CodigoPostal() {
        return $this->hasOne(Codigopostal::class,'codigospostal_id');
    }

    public function Municipio() {
        return $this->hasOne(Municipio::class,'municipio_id');
    }

    public function Ciudad() {
        return $this->hasOne(Ciudad::class,'ciudad_id');
    }

    public function Estado() {
        return $this->hasOne(Estado::class,'estado_id');
    }

    public static function findOrImport($zona,$asentamiento_id,$tipoasentamiento_id,$codigospostal_id,$municipio_id,$estado_id,$ciudad_id){
//        $obj = static::where('zona', $zona)->first();
//        if (!$obj) {
            $obj = static::create([
                'zona' => strtoupper($zona),
                'asentamiento_id' => $asentamiento_id,
                'tipoasentamiento_id' => $tipoasentamiento_id,
                'codigospostal_id' => $codigospostal_id,
                'municipio_id' => $municipio_id,
                'estado_id' => $estado_id,
                'ciudad_id' => $ciudad_id,
            ]);
//        }
        return $obj;
    }



}
