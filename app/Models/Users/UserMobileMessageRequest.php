<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Models\Users;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class UserMobileMessageRequest extends Model{



    use Notifiable, SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'usermobile_messagerequest';

    protected $fillable = [
        'id','user_id','usermobile_id', 'usermobilemessage_id', 'multicast_id','success', 'failure', 'canonical_ids','message_id',
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];

    public function users(){
        return $this->hasMany(User::class,'id','user_id');
    }

    public function MobileDevices(){
        return $this->hasMany(UserMobile::class,'id','usermobile_id');
    }

    public function MobileDeviceMessage(){
        return $this->hasMany(UserMobileMessage::class,'id','usermobilemessage_id');
    }




}
