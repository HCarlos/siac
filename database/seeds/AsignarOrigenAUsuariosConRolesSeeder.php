<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsignarOrigenAUsuariosConRolesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles_ids = [1, 10, 18, 19, 22, 23, 24, 27, 30, 32, 35, 36];
        $origen_id = 32;

        // Obtener usuarios con sus roles (para debug)
        $usuarios_con_roles = DB::table('role_user')
            ->whereIn('role_id', $roles_ids)
            ->select('user_id', DB::raw('ARRAY_AGG(role_id) as roles'))
            ->groupBy('user_id')
            ->get();

        $this->command->info("👥 Usuarios encontrados: " . $usuarios_con_roles->count());

        $asignados = 0;
        $ya_existentes = 0;

        foreach ($usuarios_con_roles as $item) {
            $user_id = $item->user_id;

            // Verificar si ya tiene el origen
            $ya_tiene_origen = DB::table('origene_user')
                ->where('user_id', $user_id)
                ->where('origene_id', $origen_id)
                ->exists();

            if (!$ya_tiene_origen) {
                DB::table('origene_user')->insert([
                    'user_id' => $user_id,
                    'origene_id' => $origen_id,
                ]);
                $asignados++;
                $this->command->info("✓ Usuario ID: {$user_id} - Roles: {$item->roles}");
            } else {
                $ya_existentes++;
                $this->command->warn("⚠ Usuario ID: {$user_id} ya tiene origen_id {$origen_id}");
            }
        }

        $this->command->info("========================================");
        $this->command->info("✅ Asignados: {$asignados}");
        $this->command->warn("⚠️  Ya existentes: {$ya_existentes}");
        $this->command->info("========================================");
    }


}
