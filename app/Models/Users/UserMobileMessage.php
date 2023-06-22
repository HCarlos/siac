<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Models\Users;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserMobileMessage extends Model{


    use Notifiable, SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'usermobile_message';

    protected $fillable = [
        'id','user_id','usermobile_id','campania','title', 'message','fecha','tags',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];
    protected $casts = ['is_read'=>'boolean',];

    public function IsRead(){
        return $this->is_read;
    }

    public function users(){
        return $this->hasMany(User::class,'id','user_id');
    }

    public function MobileDevices(){
        return $this->hasMany(UserMobile::class,'id','usermobile_id');
    }




}
