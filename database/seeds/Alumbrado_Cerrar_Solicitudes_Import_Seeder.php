<?php

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Events\DenunciaUpdateStatusGeneralEvent;
use App\Models\Denuncias\Denuncia;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class Alumbrado_Cerrar_Solicitudes_Import_Seeder extends Seeder{
    /**
     * Ejecuta la importación de solicitudes de alumbrado desde un CSV.
     *
     * Flujo general:
     * 1. Leer archivo CSV
     * 2. Procesar línea por línea
     * 3. Construir tsquery para buscar ubicación
     * 4. Crear denuncia
     * 5. Crear relaciones auxiliares
     * 6. Actualizar vista y disparar evento
     *
     * @return void
     */
    public function run()
    {
        $file = public_path('csv/alumbrado_cerrar.csv');

        if (!file_exists($file)) {
            if ($this->command) {
                $this->command->error("No existe el archivo: {$file}");
            }
            return;
        }

        $json_data = file_get_contents($file);
        $json_data = preg_split("/\n/", $json_data);

        for ($x = 1, $xMax = count($json_data) - 1; $x < $xMax; $x++) {
            try {
                if (trim($json_data[$x]) === '') {
                    continue;
                }

                $dupla = preg_split("/\t/", $json_data[$x], -1, PREG_SPLIT_NO_EMPTY);

                if (!isset($dupla[0]) || trim($dupla[0]) === '') {
                    continue;
                }

                $arr = str_getcsv($dupla[0]);

                if (count($arr) <= 1) {
                    continue;
                }

                /**
                 * ===========================
                 * EXTRACCIÓN DE DATOS
                 * ===========================
                 */
                $denuncia_id         = isset($arr[0]) ? (int) $arr[0] : 0;
                $dependencia_id      = isset($arr[52]) ? (int) $arr[52] : 0;
                $servicio_id         = isset($arr[53]) ? (int) $arr[53] : 0;
                $fecha_movto         = isset($arr[54]) ? $arr[54] : '';

                /**
                 * ===========================
                 * FECHAS
                 * ===========================
                 * Se toma la fecha del archivo y se le agrega la hora actual.
                 */
                $now = Carbon::now();

                $fecha_movimiento = !empty($fecha_movto)
                    ? Carbon::parse($fecha_movto)->setTime($now->hour, $now->minute, $now->second)
                    : null;



                /**
                 * ===========================
                 * CREACIÓN DE DENUNCIA
                 * ===========================
                 */
                $item = Denuncia::find($denuncia_id);

                if ($item) {
                    $item->dependencias()->attach($dependencia_id, [
                        'servicio_id'      => $servicio_id,
                        'estatu_id'        => 21,
                        'favorable'        => true,
                        'fecha_movimiento' => $fecha_movimiento,
                        'creadopor_id'     => 1,
                        'observaciones'    => 'Fue Cerrada con éxito, en esta fecha (carga masiva).',
                    ]);
                    $vid = new VistaDenunciaClass();
                    $vid->vistaDenuncia($item->id);
                    event(new DenunciaUpdateStatusGeneralEvent($item->id, 1, 0));

                }
            } catch (\Throwable $e) {
                if ($this->command) {
                    $this->command->error('Error en la línea ' . $x . ': ' . $e->getMessage());
                } else {
                    echo 'Error en la línea ' . $x . ': ' . $e->getMessage() . PHP_EOL;
                }
            }
        }

        if ($this->command) {
            $this->command->info('Listo!!! Proceso terminado correctamente.');
        }
    }

}
