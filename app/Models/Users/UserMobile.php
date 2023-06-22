<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Models\Users;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserMobile extends Model{

    use Notifiable, SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'usermobile';

    protected $fillable = [
        'id','user_id',
        'token','mobile_type','enabled'
    ];
    protected $casts = ['enabled'=>'boolean',];
    /**
     * @var mixed
     */

    public function users(){
        return $this->hasMany(User::class,'id','user_id');
    }

    public function IsEnabled() {
        return $this->enabled;
    }



}
