<?php

namespace App\Models\Denuncias;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class DenunciaEstatu extends Model
{
    use Notifiable, SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'denuncia_estatu';

    protected $fillable = [
        'id',
        'denuncia_id','estatu_id'
    ];
    protected $hidden = ['deleted_at','created_at','updated_at'];
    protected $casts = ['ultimo'=>'boolean',];

    public function isUltimo(){
        return $this->ultimo;
    }

}
