<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Models\Denuncias;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Denuncia_Modificado extends Model {
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'denuncia_modificadopor';

    protected $fillable = [
        'id',
        'denuncia_id','modificadopor_id','campos_modificados','antes','despues',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function denuncia(){
        return $this->hasOne(Denuncia::class,'id','denuncia_id');
    }

    public function modificadopor(){
        return $this->hasOne(User::class,'id','modificadopor_id');
    }



}
