<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 27/11/18
 * Time: 06:05 PM
 */

namespace App\Traits\Common;


use App\User;
use Spatie\Permission\Models\Role;

trait CommonTrait
{

    public function getUserFromRoles(string $role){

        $role= Role::all()->where('name',$role)->first();
        $filters = ['roles' => [$role->id]];
        $Items = User::query()
            ->filterBy($filters)
            ->get()
            ->sortBy(function($item) {
                return $item->ap_paterno.' '.$item->ap_materno.' '.$item->nombre;
            });

        return $Items;

    }






}
