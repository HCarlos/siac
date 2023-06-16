<?php

use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Agregar_Usuarios_01_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        app()['cache']->forget('spatie.permission.cache');

        $F = new FuncionesController();
        $ip   = 'root_init';//$_SERVER['REMOTE_ADDR'];
        $host = 'root_init';//gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp = 1;

        $user = new User();
        $user->nombre = 'José Miguel';
        $user->username = 'jmiguel';
        $user->email = 'jmiguel@example.com';
        $user->password = bcrypt('jmiguel');
        $user->admin = false;
        $user->empresa_id = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->email_verified_at = now();
        $user->save();
        $user->roles()->attach(2);
        $user->permissions()->attach(7);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $F->validImage($user,'profile','profile/');

        $user = new User();
        $user->nombre = 'José Antonio';
        $user->username = 'jantonio';
        $user->email = 'jantonio@example.com';
        $user->password = bcrypt('jantonio');
        $user->admin = false;
        $user->empresa_id = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->email_verified_at = now();
        $user->save();
        $user->roles()->attach(2);
        $user->permissions()->attach(7);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $F->validImage($user,'profile','profile/');

    }
}
