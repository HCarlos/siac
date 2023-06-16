<?php

namespace App\Models\Mobiles;

use App\Traits\Denuncia\ImageneTrait;
use App\Traits\Denuncia\ImagenMobileTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagemobile extends Model{

    use SoftDeletes;
    use ImagenMobileTrait;

    protected $guard_name = 'web';
    protected $table = 'imagemobile';


    protected $fillable = [
        'id', 'fecha','root','filename','filename_png','filename_thumb','titulo','descripcion','momento','denunciamobile_id','user_id','parent_id',
        'latitud','longitud','altitud',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function User(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'imagemobile_user','image_id','user_id');
    }

    public function Denuncia(){
        return $this->hasOne(Denunciamobile::class,'id','denunciamobile_id');
    }

    public function denuncias(){
        return $this->belongsToMany(Denunciamobile::class,'denunciamobile_imagemobile','imagemobile_id','denunciamobile_id');
    }

    public function child(){
        return $this->hasOne(__CLASS__,'id','parent_id');
    }

    public function childs(){
        return $this->belongsToMany(__CLASS__,'imagemobile_parent','image_id','image_parent_id');
    }


}
