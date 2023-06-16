<?php

use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        app()['cache']->forget('spatie.permission.cache');

        $F = new FuncionesController();
        $ip   = 'root_init';//$_SERVER['REMOTE_ADDR'];
        $host = 'root_init';//gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp = 1;

        $P1 = Permission::create(['name' => 'all']);
        $P2 = Permission::create(['name' => 'crear']);
        $P3 = Permission::create(['name' => 'guardar']);
        $P4 = Permission::create(['name' => 'editar']);
        $P5 = Permission::create(['name' => 'modificar']);
        $P6 = Permission::create(['name' => 'eliminar']);
        $P7 = Permission::create(['name' => 'consultar']);
        $P8 = Permission::create(['name' => 'imprimir']);
        $P9 = Permission::create(['name' => 'asignar']);
        $P10 = Permission::create(['name' => 'desasignar']);
        $P11 = Permission::create(['name' => 'sysop']);

        $role_admin = Role::create([
            'name' => 'Administrator',
            'descripcion' => 'Administrator',
            'abreviatura' => 'ADM',
            'guard_name' => 'web',
        ]);
        $role_admin->permissions()->attach($P1);

        $role_sysop = Role::create([
            'name' => 'SysOp',
            'descripcion' => 'System Operator',
            'abreviatura' => 'SysOp',
            'guard_name' => 'web',
        ]);
        $role_sysop->permissions()->attach($P11);

        $role_invitado = Role::create([
            'name' => 'Invitado',
            'descripcion' => 'Invitado',
            'abreviatura' => 'INV',
            'guard_name' => 'web',
        ]);
        $role_invitado->permissions()->attach($P7);

        $user = new User();
        $user->nombre = 'Administrador';
        $user->username = 'Admin';
        $user->email = 'sentauro@gmail.com';
        $user->password = bcrypt('secret');
        $user->genero = 1;
        $user->admin = true;
        $user->empresa_id = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->email_verified_at = now();
        $user->save();
        $user->roles()->attach($role_admin);
        $user->permissions()->attach($P1);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $F->validImage($user,'profile','profile/');

        $user = new User();
        $user->nombre = 'System Operator';
        $user->username = 'SysOp';
        $user->email = 'sysop@example.com';
        $user->password = bcrypt('sysop');
        $user->admin = false;
        $user->empresa_id = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->email_verified_at = now();
        $user->save();
        $user->roles()->attach($role_sysop);
        $user->permissions()->attach($P11);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $F->validImage($user,'profile','profile/');

        $user = new User();
        $user->nombre = 'Invitado';
        $user->username = 'Invitado';
        $user->email = 'invitado@example.com';
        $user->password = bcrypt('Invitado');
        $user->admin = false;
        $user->empresa_id = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->email_verified_at = now();
        $user->save();
        $user->roles()->attach($role_invitado);
        $user->permissions()->attach($P7);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $F->validImage($user,'profile','profile/');


        Role::create(['name'=>'JEFE','descripcion'=>'Jefe','abreviatura'=>'JEFE','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'SUBJEFE','descripcion'=>'Subjefe','abreviatura'=>'SUBJ','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'REPORTES','descripcion'=>'Reportes','abreviatura'=>'REP','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'CAPTURISTA_A','descripcion'=>'Capturista_A','abreviatura'=>'CAPA','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'CAPTURISTA_B','descripcion'=>'Capturista_B','abreviatura'=>'CAPB','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'CAPTURISTA_C','descripcion'=>'Capturista_C','abreviatura'=>'CAPC','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'ENLACE','descripcion'=>'Enlace','abreviatura'=>'ENL','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'CIUDADANO','descripcion'=>'Ciudadano','abreviatura'=>'CIU','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'CIUDADANO_INTERNET','descripcion'=>'Ciudadano','abreviatura'=>'CIUINT','guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'DELEGADO','descripcion'=>'Delegado','abreviatura'=>'DEL','guard_name'=>'web'])->permissions()->attach($P7);

    }



}
