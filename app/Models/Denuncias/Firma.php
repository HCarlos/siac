<?php

namespace App\Models\Denuncias;

use App\Traits\Denuncia\ImageneTrait;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firma extends Model{

    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'firmas';

    protected $fillable = [
        'id', 'archivo_cer','sello_cer','archivo_key','sello_key','password','cadena_original','hash','sello','valido','fecha_firmado','firmadopor_id',
        'ip','host',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];
    protected $dates = ['fecha_firmado',];

    public function denuncia(){
        return $this->hasOne(Denuncia::class,'id','denuncia_id');
    }

    public function denuncias(){
        return $this->belongsToMany(Denuncia::class,'denuncia_firma','firma_id','denuncia_id');
    }

    public function firmadopor_id(){
        return $this->hasOne(User::class,'id','firmadopor_id');
    }


}
