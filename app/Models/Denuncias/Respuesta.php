<?php
/**
 * Copyright (c) 2019. Realizado por Carlos Hidalgo
 */

namespace App\Models\Denuncias;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Respuesta extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'respuestas';

    protected $fillable = [
        'id', 'fecha','respuesta','observaciones','denuncia__id','user__id','parent__id'
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

//    public function Denuncia() {
//        return $this->hasMany(Denuncia::class,'denuncia_id');
//    }

//    public function Users() {
//        return $this->hasMany(User::class,'user_id');
//    }
//

    public function user(){
        return $this->hasOne(User::class,'id','user__id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'respuesta_user','respuesta_id','user_id');
    }

    public function denuncia(){
        return $this->hasOne(Denuncia::class,'id','denuncia__id');
    }

    public function denuncias(){
        return $this->belongsToMany(Denuncia::class,'denuncia_respuesta','respuesta_id','denuncia_id');
    }

    public function child(){
        return $this->hasOne(Respuesta::class,'id','parent__id');
    }

    public function childs(){
        return $this->belongsToMany(Respuesta::class,'parent_respuesta','respuesta_id','respuesta_parent_id');
    }

}
