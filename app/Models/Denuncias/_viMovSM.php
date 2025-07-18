<?php


namespace App\Models\Denuncias;

use App\Filters\Denuncia\Count\DenunciaAmbitoFilterCount;
use App\Filters\Denuncia\Count\GetDenunciasAmbitoFilterCount;
use App\Filters\Denuncia\Count\GetDenunciasEstatusAmbitoFilterCount;
use App\Filters\Denuncia\DenunciaAmbitoFilter;
use App\Filters\Denuncia\DenunciaFilter;
use App\Filters\Denuncia\GetDenunciasAmbitoItemCustomFilter;
use App\Filters\Denuncia\GetDenunciasItemCustomFilter;
use App\Models\Catalogos\CentroLocalidad;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Origen;
use App\Models\Catalogos\Prioridad;
use App\Models\Catalogos\Servicio;
use App\Traits\Denuncia\DenunciaTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class _viMovSM extends Model{

//    use SoftDeletes;
    use DenunciaTrait;

    protected $guard_name = 'web';
    protected $table = '_vimov_filter_sm';

//    public function scopeFilterBy($query, $filters){
//        return (new DenunciaFilter())->applyTo($query, $filters);
//    }
//    public function scopeGetDenunciasItemCustomFilter($query, $filters){
//        return (new GetDenunciasItemCustomFilter())->applyTo($query, $filters);
//    }
//
//    public function scopeAmbitoFilterBy($query, $filters){
//        return (new DenunciaAmbitoFilter())->applyTo($query, $filters);
//    }
//    public function scopeGetDenunciasAmbitoItemCustomFilter($query, $filters){
//        return (new GetDenunciasAmbitoItemCustomFilter())->applyTo($query, $filters);
//    }
//    public function scopeGetDenunciasAmbitoFilterCount($query, $filters){
//        return (new GetDenunciasAmbitoFilterCount())->applyTo($query, $filters);
//    }
//
//    public function scopeFilterByCount($query, $filters){
//        return (new DenunciaAmbitoFilterCount())->applyTo($query, $filters);
//    }
//    public function scopeGetDenunciasEstatusAmbitoFilterCount($query, $filters){
//        return (new GetDenunciasEstatusAmbitoFilterCount())->applyTo($query, $filters);
//    }

    public function centroLocalidad(){
        return $this->hasOne(CentroLocalidad::class,'id','centro_localidad_id');
    }


    public function semaforo_ultimo_estatus(){

        $sem = 1;

        $finicio = Carbon::now();
        $ffin = Carbon::parse($this->fecha_ingreso);

        if ($this->ultimo_estatus === "ATENDIDO" ||
            $this->ultimo_estatus === "ATENDIDA" ||
            $this->ultimo_estatus === "RECHAZADA"
        ){
            $finicio = Carbon::parse($this->fecha_ingreso);
            $ffin = Carbon::parse($this->fecha_ultimo_estatus);
        }
        $dias = $finicio->diffInDays($ffin);

        if ( $dias <= $this->dias_ejecucion ){ $sem = 1; $class_color = 'text-verde-semaforo';  }
        if ( $dias > $this->dias_ejecucion && $dias <= $this->dias_maximos_ejecucion ){ $sem = 2; $class_color = 'text-amarillo-semaforo';}
        if ( $dias > $this->dias_maximos_ejecucion ){ $sem = 3; $class_color = 'text-rojo-semaforo';}

        return [
            'sem' => $sem,
            'dias' => $dias,
            'class_color' => $class_color,
            ];

    }






}
