<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasRoles;
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'permissions';

    protected $fillable = ['id','name','descripcion','abreviatura',];

    public static function findByName($name){
        return static::where( 'name',$name )->first();
    }

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function users() {
        // Esta en muchos Roles
        return $this->belongsToMany(User::class);
    }

}
