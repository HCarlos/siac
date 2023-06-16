<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Models\Mobiles;

use App\Traits\Denuncia\ImagenMobileTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Respuestamobile extends Model{


    use SoftDeletes;
    use ImagenMobileTrait;
    protected $guard_name = 'web';
    protected $table = 'respuestamobile';


    protected $fillable = [
        'id', 'fecha','respuesta','observaciones','user_id','denunciamobile_id','parent_id',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function User(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'respuestamobile_user','respuestamobile_id','user_id');
    }

    public function Denuncia(){
        return $this->hasOne(Denunciamobile::class,'id','denunciamobile_id');
    }

    public function denuncias(){
        return $this->belongsToMany(Denunciamobile::class,'denunciamobile_respuestamobile','respuestamobile_id','denunciamobile_id');
    }

    public function child(){
        return $this->hasOne(__CLASS__,'id','parent_id');
    }

    public function childs(){
        return $this->belongsToMany(__CLASS__,'respuestamobile_parent','respuestamobile_id','respuestamobile_parent_id');
    }




}
