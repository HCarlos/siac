<?php

namespace App\Models\Denuncias;

use App\Filters\Catalogo\ServicioFilter;
use App\Models\Catalogos\Area;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Medida;
use App\Models\Catalogos\Subarea;
use App\Traits\Catalogos\Estructura\Servicio\ServicioTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class _viServicios extends Model{

    use ServicioTrait;

    protected $guard_name = 'web';
    protected $table = '_viservicios';

    public function scopeSearch($query, $search){
        if ( !$search || $search == "" || is_null($search) ) return $query;
        $search = strtoupper($search);
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


    public function dependencias(){
        return $this->belongsToMany(Dependencia::class,'denuncia_dependencia_servicio_estatus','servicio_id','dependencia_id')
            ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida','creadopor_id');
    }

    public function denuncias(){
        return $this->belongsToMany(Denuncia::class,'denuncia_dependencia_servicio_estatus','servicio_id','denuncia_id')
            ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida','creadopor_id');
    }

    public function estatus(){
        return $this->belongsToMany(Estatu::class,'denuncia_dependencia_servicio_estatus','servicio_id','estatu_id')
            ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida','creadopor_id');
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
