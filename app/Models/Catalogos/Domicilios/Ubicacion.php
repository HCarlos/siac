<?php
/**
 * Copyright (c) 2018. Realizado por Carlos Hidalgo
 */

namespace App\Models\Catalogos\Domicilios;

use App\Filters\Catalogo\Domicilio\UbicacionFilter;
use App\Traits\Catalogos\Domicilio\Ubicacion\UbicacionTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ubicacion extends Model
{

    use SoftDeletes;
    use UbicacionTrait;

    protected $guard_name = 'web';
    protected $table = 'ubicaciones';

    protected $fillable = [
        'id', 'calle','num_ext','num_int','colonia', 'comunidad','ciudad','municipio','estado','pais', 'cp',
        'latitud','longitud','searchtext',
        'calle_id', 'colonia_id','comunidad_id','ciudad_id', 'municipio_id','estado_id', 'codigopostal_id',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function scopeFilterBy($query,$filerts){
        return (new UbicacionFilter())->applyTo($query, $filerts);
    }

    public function scopeSearch($query, $search){
        if (!$search || $search == "" || $search == null) return $query;
        return $query->whereRaw("searchtext @@ to_tsquery('spanish', ?)", [$search])
            ->orderByRaw("calle, num_int, num_ext, colonia ASC");
    }
//->orderByRaw("ts_rank(searchtext, to_tsquery('spanish', ?)) DESC", [$search]);

    public function calle() {
        return $this->hasOne(Calle::class,'id','calle_id');
    }
    public function calles(){
        return $this->belongsToMany(Calle::class,'calle_ubicacion','ubicacion_id','calle_id');
    }

    public function colonia() {
        return $this->hasOne(Colonia::class,'id','colonia_id');
    }
    public function colonias(){
        return $this->belongsToMany(Colonia::class,'colonia_ubicacion','ubicacion_id','colonia_id');
    }

    public function comunidad() {
        return $this->hasOne(Localidad::class,'id','comunidad_id');
    }
    public function comunidades(){
        return $this->belongsToMany(Comunidad::class,'comunidad_ubicacion','ubicacion_id','comunidad_id');
    }

    public function ciudad() {
        return $this->hasOne(Ciudad::class,'id','ciudad_id');
    }
    public function ciudades(){
        return $this->belongsToMany(Ciudad::class,'ciudad_ubicacion','ubicacion_id','ciudad_id');
    }

    public function municipio() {
        return $this->hasOne(Municipio::class,'id','municipio_id');
    }
    public function municipios(){
        return $this->belongsToMany(Municipio::class,'municipio_ubicacion','ubicacion_id','municipio_id');
    }

    public function estado() {
        return $this->hasOne(Estado::class,'id','estado_id');
    }
    public function estados(){
        return $this->belongsToMany(Estado::class,'estado_ubicacion','ubicacion_id','estado_id');
    }

    public function codigopostal() {
        return $this->hasOne(Codigopostal::class,'id','codigopostal_id');
    }
    public function codigospostales(){
        return $this->belongsToMany(Codigopostal::class,'codigopostal_ubicacion','ubicacion_id','codigopostal_id');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function getUbicacionAttribute() {
        return trim($this->calle).' '.trim($this->num_ext).' '.trim($this->num_int).', '.trim($this->colonia).', '.trim($this->comunidad).', '.trim($this->ciudad).', '.trim($this->municipio);
    }


}
