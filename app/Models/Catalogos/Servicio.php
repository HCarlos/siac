<?php

namespace App\Models\Catalogos;

use App\Filters\Catalogo\ServicioFilter;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Denuncias\Denuncia;
use App\Traits\Catalogos\Estructura\Servicio\ServicioTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use SoftDeletes;
    use ServicioTrait;

    protected $guard_name = 'web';
    protected $table = 'servicios';

    protected $fillable = [
        'id', 'servicio','habilitado', 'medida_id', 'subarea_id','orden_impresion',
        'root','filename','filename_png','filename_thumb', 'ambito_servicio',
        'is_visible_mobile', 'nombre_mobile', 'url_image_mobile', 'orden_image_mobile',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];
    protected $casts = ['habilitado'=>'boolean','is_visible_mobile'=>'boolean',];

    public function scopeSearch($query, $search){
        if ( !$search || $search == "" || is_null($search) ) return $query;
        $search = strtoupper($search);
//        $filters  = $search;
//        $F        = new FuncionesController();
//        $tsString = $F->string_to_tsQuery( strtoupper($filters),' & ');
        return $query->whereRaw("searchtextservicio @@ to_tsquery('spanish', ?)", [$search])
            ->orderByRaw("ts_rank(searchtextservicio, to_tsquery('spanish', ?)) ASC", [$search]);
    }

    public function scopeFilterBy($query, $filters){
        return (new ServicioFilter())->applyTo($query, $filters);
    }

    public function isEnabled(){
        return $this->habilitado;
    }

    public function isVisibleMobile(){
        return $this->is_visible_mobile;
    }

    public function medida() {
        return $this->hasOne(Medida::class,'id', 'medida_id');
    }

//    public function medidas() {
//        return $this->hasOne(Medida::class,'id', 'medida_id');
//    }


    public function subarea() {
        return $this->hasOne(Subarea::class,'id','subarea_id');
    }

    public function subareas() {
        return $this->belongsToMany(Subarea::class,'servicio_subarea','servicio_id','subarea_id');
    }

    public function area() {
        return $this->hasOne(Area::class,'id','area_id');
    }

    public function dependencia(){
        return $this->hasOne(Dependencia::class,'id','servicio_id');
    }

    public function dependencias(){
        return $this->belongsToMany(Dependencia::class,'denuncia_dependencia_servicio_estatus','servicio_id','dependencia_id')
        ->withPivot('fecha_movimiento','observaciones','favorable');
    }

    public function denuncias(){
        return $this->belongsToMany(Denuncia::class,'denuncia_dependencia_servicio_estatus','servicio_id','denuncia_id')
        ->withPivot('fecha_movimiento','observaciones','favorable');
    }

    public function estatus(){
        return $this->belongsToMany(Estatu::class,'denuncia_dependencia_servicio_estatus','servicio_id','estatu_id')
        ->withPivot('fecha_movimiento','observaciones','favorable');
    }

    static function getQueryServiciosFromDependencias($id=0){

        $items =  static::whereHas('subareas', function($p) use ($id) {
            $p->whereHas("areas", function($q) use ($id){
                return $q->where("dependencia_id",$id);
            });
        })->orderBy('servicio')->get();

        $data = [];
        foreach ($items as $item){
            $suba = trim($item->subarea->subarea) == "GENERAL" ? "" : trim($item->subarea->subarea).' - ';
            $area = trim($item->subarea->area->area) == "GENERAL" ? "" : trim($item->subarea->area->area).' - ';
            $depe = trim($item->subarea->area->dependencia->abreviatura) == "GENERAL" ? "" : trim($item->subarea->area->dependencia->abreviatura);
            $data[]=array('id'=>$item->id,'servicio'=>$item->servicio.' - '.$suba.$area.$depe);
        }

        return json_decode( json_encode($data));

    }


    public static function findOrImport($servicio,$habilitado,$medida_id,$subarea_id){
        $obj = static::where('servicio', trim($servicio))->first();
        if (!$obj) {
            $obj = static::create([
                'servicio' => strtoupper(trim($servicio)),
                'habilitado' => $habilitado,
                'medida_id' => $medida_id,
                'subarea_id' => $subarea_id,
            ]);
            if ($obj->id > 0) {
                $obj->subareas()->attach($subarea_id);
            }
        }
        return $obj;
    }



}
