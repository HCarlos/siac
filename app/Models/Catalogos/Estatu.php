<?php

namespace App\Models\Catalogos;

use App\Filters\Catalogo\EstatuFilter;
use App\Models\Denuncias\Denuncia;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estatu extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'estatus';

    protected $fillable = [
        'id', 'estatus','predeterminado','abreviatura','orden_impresion','estatus_cve','resuelto',
        'favorable','ambito_estatus','requiere_imagen',
    ];

    protected $casts = ['predeterminado'=>'boolean','resuelto'=>'boolean',];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function isDefault(){
        return $this->predeterminado;
    }
    public function isResuelto(){
        return $this->resuelto;
    }


    public function scopeFilterBy($query, $filters){
        return (new EstatuFilter())->applyTo($query, $filters);
    }

    public function dependencias(){
        return $this->belongsToMany(Dependencia::class);
    }

    public function denuncias(){
        return $this->belongsToMany(Denuncia::class,'denuncia_dependencia_servicio_estatus','estatu_id','denuncia_id')
        ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida','creadopor_id');
    }

    public function denuncia_dependencias(){
        return $this->belongsToMany(Dependencia::class,'denuncia_dependencia_servicio_estatus','estatu_id','dependencia_id')
        ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida','creadopor_id');
    }

    public function servicios(){
        return $this->belongsToMany(Servicio::class,'denuncia_dependencia_servicio_estatus','estatu_id','servicio_id')
        ->withPivot('fecha_movimiento','observaciones','favorable','fue_leida','creadopor_id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'estatu_user','estatu_id','user_id')
            ->withPivot('orden','predeterminado');
    }




    public static function findOrImport($estatus){
        $obj = static::where('estatus', trim($estatus))->first();
        if (!$obj) {
            $obj = static::create([
                'estatus' => strtoupper(trim($estatus)),
            ]);
        }
        return $obj;
    }


}
