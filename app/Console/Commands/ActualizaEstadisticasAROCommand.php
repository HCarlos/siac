<?php
/*
 * Comando Artisan para actualizar las estadísticas ARO
 * de todas las denuncias con ambito_dependencia = 2 (Servicios Municipales).
 *
 * Uso manual:
 *   php artisan siac:actualiza-estadisticas-aro
 *   php artisan siac:actualiza-estadisticas-aro --dry-run
 *   php artisan siac:actualiza-estadisticas-aro --limit=10
 *
 * Cronjob (vía Laravel Scheduler en Kernel.php):
 *   * * * * * php artisan schedule:run >> /dev/null 2>&1
 */

namespace App\Console\Commands;

use App\Classes\Denuncia\ActualizaEstadisticasARO;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActualizaEstadisticasAROCommand extends Command
{
    /**
     * Nombre y firma del comando Artisan.
     * Opciones:
     *   --dry-run  Solo muestra qué procesaría, sin ejecutar cambios.
     *   --limit=N  Limita el número de denuncias a procesar (útil para pruebas).
     *
     * @var string
     */
    protected $signature = 'siac:actualiza-estadisticas-aro
                            {--dry-run : Solo muestra los IDs a procesar, sin ejecutar cambios}
                            {--limit=0 : Limita el número de denuncias a procesar (0 = todas)}';

    /**
     * Descripción del comando.
     *
     * @var string
     */
    protected $description = 'Actualiza las estadísticas ARO (días atendida/rechazada/observada) de las denuncias con ambito_dependencia = 2 (Servicios Municipales)';

    /**
     * Crea una nueva instancia del comando.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ejecuta el comando.
     *
     * @return int
     */
    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $limite = (int) $this->option('limit');

        $this->info('[SIAC] Iniciando actualización de estadísticas ARO...');
        if ($dryRun) {
            $this->warn('[SIAC] Modo DRY-RUN activado — no se ejecutarán cambios.');
        }
        if ($limite > 0) {
            $this->warn("[SIAC] Límite activado — se procesarán máximo {$limite} denuncias.");
        }

        // Fecha de corte: solo denuncias desde el 18-11-2025 hasta hoy (rango fijo de inicio)
        $fechaCorte = '2025-11-18';

        // Construir consulta base
        $query = DB::table('_videnuncias')
            ->where('ambito_dependencia', 2)
            ->whereDate('fecha_ingreso', '>=', $fechaCorte)
            ->whereDate('fecha_ingreso', '<=', now())
            ->orderByDesc('id');

        if ($limite > 0) {
            $query->limit($limite);
        }

        $ids = $query->pluck('id')->toArray();

        $total = count($ids);
        $this->info("[SIAC] Denuncias a procesar: {$total}");

        if ($total === 0) {
            $this->warn('[SIAC] No se encontraron denuncias. Finalizando.');
            return 0;
        }

        // En dry-run solo mostramos los primeros 20 IDs como muestra
        if ($dryRun) {
            $muestra = array_slice($ids, 0, 20);
            $this->table(['denuncia_id'], array_map(fn($id) => [$id], $muestra));
            if ($total > 20) {
                $this->line("... y " . ($total - 20) . " más.");
            }
            $this->info('[SIAC] DRY-RUN completado. Sin cambios realizados.');
            return 0;
        }

        // Ejecución real
        $procesadas = 0;
        $errores    = 0;
        $a = new ActualizaEstadisticasARO();

        foreach ($ids as $denuncia_id) {
            try {
                $a->ActualizaEstadisticasARO($denuncia_id);
                $procesadas++;
            } catch (\Exception $e) {
                $errores++;
                Log::error("[ActualizaEstadisticasAROCommand] Error en denuncia_id={$denuncia_id}: " . $e->getMessage());
            }
        }

        $this->info("[SIAC] Procesadas: {$procesadas} | Errores: {$errores}");
        $this->info('[SIAC] Actualización ARO completada.');

        return 0;
    }
}
