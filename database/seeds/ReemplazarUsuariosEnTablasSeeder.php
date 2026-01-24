<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ReemplazarUsuariosEnTablasSeeder extends Seeder
{
    /**
     * Reemplaza user_id_baja por user_id_alta en múltiples tablas pivote.
     * Ignora registros donde user_id_baja = 0
     */
    public function run()
    {
        // 1. Array de mapeo de usuarios (user_id_baja -> user_id_alta)
        $mapeo_usuarios = [
            ['user_id_baja' => 123, 'user_id_alta' => 321],
            ['user_id_baja' => 0, 'user_id_alta' => 321],      // Este será ignorado
            ['user_id_baja' => 456, 'user_id_alta' => 789],
            // Agrega más mapeos según necesites
        ];

        // 2. Lista de tablas a actualizar
        $tablas = [
            'role_user',
            'permission_user',
            'dependencia_user',
            'estatu_user',
            'servicioscategoria_user',
            'origene_user',
            'prioridade_user',
            'servicio_user',
        ];

        $this->command->info("========================================");
        $this->command->info("🔄 Iniciando reemplazo de usuarios");
        $this->command->info("========================================");

        // 3. Resumen de operaciones
        $resumen_global = [];
        $errores_global = [];

        // 4. Procesar cada tabla
        foreach ($tablas as $tabla) {
            $this->command->info("\n📋 Procesando tabla: {$tabla}");

            $registros_actualizados = 0;
            $registros_ignorados = 0;

            // 5. Procesar cada mapeo de usuarios
            foreach ($mapeo_usuarios as $mapeo) {
                $user_id_baja = $mapeo['user_id_baja'];
                $user_id_alta = $mapeo['user_id_alta'];

                // Ignorar si user_id_baja = 0
                if ($user_id_baja === 0 || $user_id_baja == 0) {
                    $registros_ignorados++;
                    $this->command->warn("  ⚠️  Ignorado: user_id_baja = 0");
                    continue;
                }

                try {
                    // Verificar si existen registros con user_id_baja
                    $existe = DB::table($tabla)
                        ->where('user_id', $user_id_baja)
                        ->exists();

                    if ($existe) {
                        // Actualizar los registros
                        $afectados = DB::table($tabla)
                            ->where('user_id', $user_id_baja)
                            ->update(['user_id' => $user_id_alta]);

                        $registros_actualizados += $afectados;

                        $this->command->info("  ✓ Reemplazado: {$user_id_baja} → {$user_id_alta} ({$afectados} registros)");
                    } else {
                        $this->command->comment("  ℹ️  No hay registros con user_id = {$user_id_baja}");
                    }

                } catch (\Exception $e) {
                    $error_msg = "Error en tabla {$tabla}, mapeo {$user_id_baja}→{$user_id_alta}: " . $e->getMessage();
                    $errores_global[] = $error_msg;
                    $this->command->error("  ✗ {$error_msg}");
                }
            }

            // Guardar resumen por tabla
            $resumen_global[$tabla] = [
                'actualizados' => $registros_actualizados,
                'ignorados' => $registros_ignorados,
            ];
        }

        // 6. Mostrar resumen final
        $this->command->info("\n========================================");
        $this->command->info("📊 RESUMEN FINAL");
        $this->command->info("========================================");

        foreach ($resumen_global as $tabla => $stats) {
            $this->command->info("📋 {$tabla}:");
            $this->command->info("   ✅ Actualizados: {$stats['actualizados']}");
            $this->command->warn("   ⚠️  Ignorados: {$stats['ignorados']}");
        }

        if (!empty($errores_global)) {
            $this->command->error("\n❌ ERRORES ENCONTRADOS:");
            foreach ($errores_global as $error) {
                $this->command->error("   • {$error}");
            }
        }

        $this->command->info("\n✅ Proceso completado");
        $this->command->info("========================================");
    }
}
