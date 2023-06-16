<?php

namespace App\Models\Catalogos\Domicilios;

use App\Filters\Catalogo\Domicilio\ColoniaFilter;
use App\Http\Controllers\Funciones\FuncionesController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colonia extends Model
{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'colonias';

    protected $fillable = [
        'id', 'colonia', 'cp','altitud','latitud','longitud','nomenclatura',
        'codigopostal_id','comunidad_id','tipocomunidad_id', 'colonia_mig_id',
        'is_unificadora',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];
    protected $casts = ['is_unificadora'=>'boolean',];

    public function scopeSearch($query, $search){
        if (!$search || $search == "" || $search == null) return $query;
            $search = strtoupper($search);
            $filters  = $search;
            $F        = new FuncionesController();
            $tsString = $F->string_to_tsQuery( strtoupper($filters),' & ');
            return $query->whereRaw("searchtextcolonia @@ to_tsquery('spanish', ?)", [$tsString])
                ->orderByRaw("ts_rank(searchtextcolonia, to_tsquery('spanish', ?)) ASC", [$tsString]);
    }

    public function scopeFilterBy($query, $filters){
        return (new ColoniaFilter())->applyTo($query,$filters);
    }

    public function codigoPostal() {
        return $this->hasOne(Codigopostal::class,'id','codigopostal_id');
    }
    public function codigospostales(){
        return $this->belongsToMany(Codigopostal::class,'codigopostal_colonia','colonia_id','codigopostal_id');
    }

    public function comunidad() {
        return $this->hasOne(Comunidad::class,'id','comunidad_id');
    }
    public function comunidades(){
        return $this->belongsToMany(Comunidad::class,'colonia_comunidad','colonia_id','comunidad_id');
    }

    public function tipoComunidad() {
        return $this->hasOne(Tipocomunidad::class,'id','tipocomunidad_id');
    }
    public function tipocomunidades(){
        return $this->belongsToMany(Tipocomunidad::class,'colonia_tipocomunidad','colonia_id','tipocomunidad_id');
    }

    public static function findOrImport($colonia,$cp,$altitud,$latitud,$longitud,$codigospostal_id,$comunidad_id,$tipocomunidad_id){
        $obj = static::where('colonia', trim($colonia))
            ->first();
        if (!$obj) {
            if ( Codigopostal::all()->contains( $codigospostal_id) ){
                $obj = static::create([
                    'colonia' => strtoupper(trim($colonia)),
                    'cp' => strtoupper($cp),
                    'altitud' => $altitud,
                    'latitud' => $latitud,
                    'longitud' => $longitud,
                    'codigopostal_id' => $codigospostal_id,
                    'comunidad_id' => $comunidad_id,
                    'tipocomunidad_id' => $tipocomunidad_id,
                ]);


            }
        }
        return $obj;
    }



}
