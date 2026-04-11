<?php

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Events\DenunciaUpdateStatusGeneralEvent;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\CentroLocalidad;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Denuncias\_viServicios;
use App\Models\Denuncias\Denuncia;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Obras_Solicitudes_Import_Seeder extends Seeder{
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
        $file = public_path('csv/obras_import.csv');

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
                $ciudadano_id        = isset($arr[0]) ? (int) $arr[0] : 0;
                $calle_y_num         = isset($arr[1]) ? trim($arr[1]) : '';
                $calle_y_num         = mb_substr($calle_y_num, 0, 250, 'UTF-8');
                $centro_localidad    = isset($arr[2]) ? trim($arr[2]) : '';
                $centro_localidad_id = isset($arr[3]) ? (int) $arr[3] : 0;
                $codigo_postal       = isset($arr[4]) ? (int) $arr[4] : 86035;
                $latitud             = isset($arr[5]) ? (float) $arr[5] : 0;
                $longitud            = isset($arr[6]) ? (float) $arr[6] : 0;
                $servicio_id         = isset($arr[8]) ? (int) $arr[8] : 0;
                $cantidad            = isset($arr[9]) ? (float) $arr[9] : 0;
                $descripcion         = isset($arr[10]) ? trim($arr[10]) : '';

                /**
                 * ===========================
                 * FECHAS
                 * ===========================
                 * Se toma la fecha del archivo y se le agrega la hora actual.
                 */
                $now = Carbon::now();

                $fecha_ingreso = !empty($arr[12])
                    ? Carbon::createFromFormat('d/m/Y', trim($arr[12]))->setTime($now->hour, $now->minute, $now->second)
                    : null;

                $fechaEjecucion = $fecha_ingreso
                    ? (clone $fecha_ingreso)->addDays(3)->format('Y-m-d H:i:s')
                    : null;

                $fechaLimite = $fecha_ingreso
                    ? (clone $fecha_ingreso)->addDays(3)->format('Y-m-d H:i:s')
                    : null;

                /**
                 * ===========================
                 * PREPARACIÓN DE BÚSQUEDA FULL TEXT
                 * ===========================
                 * Este bloque es compatible con scopeSearch() que usa:
                 * to_tsquery('spanish', ?)
                 */
                $filters = trim($calle_y_num . ' ' . $centro_localidad);

                $F = new FuncionesController();
                $filters = mb_strtolower($filters, 'UTF-8');
                $filters = $F->str_sanitizer($filters);
                $tsString = $F->string_to_tsQuery($filters, ' & ');

                /**
                 * ===========================
                 * SERVICIO
                 * ===========================
                 */
                $servicio = _viServicios::find($servicio_id);

                if (!$servicio) {
                    throw new \Exception("No se encontró el servicio con ID {$servicio_id}");
                }

                /**
                 * ===========================
                 * UBICACIÓN
                 * ===========================
                 */
                if ($tsString === '') {
                    $ubi = null;
                } else {
                    $ubi = Ubicacion::query()
                        ->where('estatus_cve', 1)
                        ->search($tsString)
                        ->orderBy('id')
                        ->first();
                }

                if (is_null($ubi)) {
                    $ubi = Ubicacion::find(1);
                }

                /**
                 * ===========================
                 * CENTRO DE LOCALIDAD Y COORDENADAS
                 * ===========================
                 */
                $cl = CentroLocalidad::find($centro_localidad_id);

                $latlng = Denuncia::query()
                    ->where('centro_localidad_id', $centro_localidad_id)
                    ->where('latitud', '<>', 0)
                    ->where('longitud', '<>', 0)
                    ->first();

                if ($latlng) {
//                    $latitud = (float) $latlng->latitud;
//                    $longitud = (float) $latlng->longitud;
                }

                /**
                 * ===========================
                 * ARMADO DEL REGISTRO
                 * ===========================
                 */
                $Item = [
                    'fecha_ingreso'                => $fecha_ingreso,
                    'oficio_envio'                 => '',
                    'folio_sas'                    => '',
                    'fecha_oficio_dependencia'     => $fecha_ingreso,
                    'fecha_ejecucion'              => $fechaEjecucion,
                    'fecha_limite'                 => $fechaLimite,
                    'descripcion'                  => $descripcion,
                    'referencia'                   => '',
                    'clave_identificadora'         => '',
                    'calle'                        => $calle_y_num,
                    'num_ext'                      => '',
                    'num_int'                      => '',
                    'colonia'                      => $cl->colonia ?? '',
                    'comunidad'                    => $cl->delegacion ?? '',
                    'ciudad'                       => 'Villahermosa',
                    'municipio'                    => 'Centro',
                    'estado'                       => 'Tabasco',
                    'cp'                           => $codigo_postal,
                    'latitud'                      => $latitud ?: 17.998887170641467,
                    'longitud'                     => $longitud ?: -92.94474352674484,
                    'altitud'                      => 10,
                    'search_google'                => $calle_y_num,
                    'gd_ubicacion'                 => $centro_localidad,
                    'codigo_postal_manual'         => $codigo_postal,
                    'search_google_select'         => $calle_y_num,
                    'prioridad_id'                 => 2,
                    'origen_id'                    => 1,
                    'dependencia_id'               => $servicio->dependencia_id ?? null,
                    'ubicacion_id'                 => $ubi->id ?? null,
                    'servicio_id'                  => $servicio_id,
                    'estatus_id'                   => 16,
                    'ciudadano_id'                 => $ciudadano_id,
                    'creadopor_id'                 => 1,
                    'modificadopor_id'             => 1,
                    'domicilio_ciudadano_internet' => isset($ubi->domicilio_ciudadano_internet)
                        ? strtoupper(trim($ubi->domicilio_ciudadano_internet))
                        : '',
                    'observaciones'                => $ubi->observaciones ?? '',
                    'ip'                           => FuncionesController::getIp(),
                    'host'                         => config('atemun.public_url') ?: 'http://localhost:8000',
                    'ambito'                       => $ubi->ambito ?? 0,
                    'centro_localidad_id'          => $centro_localidad_id ?: null,
                    'cantidad'                     => $cantidad,
                ];

                /**
                 * ===========================
                 * CREACIÓN DE DENUNCIA
                 * ===========================
                 */
                $item = Denuncia::create($Item);

                /**
                 * ===========================
                 * RELACIONES AUXILIARES
                 * ===========================
                 */


                $this->attaches($item, null, null);

                /**
                 * ===========================
                 * ACTUALIZACIÓN DE VISTA Y EVENTO
                 * ===========================
                 */

                $vid = new VistaDenunciaClass();
                $vid->vistaDenuncia($item->id);
                event(new DenunciaUpdateStatusGeneralEvent($item->id, 1, 0));

                /**
                 * ===========================
                 * ESTATUS FINAL ATENDIDO
                 * ===========================
                 */
                if ($item) {
                    // +3 segundos respecto a fecha_ingreso para diferenciar timestamps
                    $fecha_movimiento = !empty($arr[11])
                        ? Carbon::createFromFormat('d/m/Y', trim($arr[11]))->setTime($now->hour, $now->minute, $now->second)->addSeconds(3)
                        : null;

                    $item->dependencias()->attach($item->dependencia_id, [
                        'servicio_id'      => $item->servicio_id,
                        'estatu_id'        => 17,
                        'favorable'        => true,
                        'fecha_movimiento' => $fecha_movimiento,
                        'creadopor_id'     => 1,
                        'observaciones'    => 'Fue atendida con éxito, en esta fecha (carga masiva).',
                    ]);
                    $vid = new VistaDenunciaClass();
                    $vid->vistaDenuncia($item->id);
                    event(new DenunciaUpdateStatusGeneralEvent($item->id, 1, 0));
                }
                if ($item) {
                    // +6 segundos respecto a fecha_ingreso para diferenciar timestamps
                    $fecha_movimiento = !empty($arr[11])
                        ? Carbon::createFromFormat('d/m/Y', trim($arr[11]))->setTime($now->hour, $now->minute, $now->second)->addSeconds(6)
                        : null;

                    $item->dependencias()->attach($item->dependencia_id, [
                        'servicio_id'      => $item->servicio_id,
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

    /**
     * Inserta las relaciones auxiliares de la denuncia.
     *
     * @param mixed $Item
     * @param mixed $item_viejito
     * @param mixed $item_nuevo
     * @return mixed
     */
    public function attaches($Item, $item_viejito, $item_nuevo)
    {
        try {
            $user_id = 1;

            /**
             * ===========================
             * PRIORIDAD
             * ===========================
             */
            $Obj = DB::table('denuncia_prioridad')
                ->where('denuncia_id', '=', $Item->id)
                ->where('prioridad_id', '=', $Item->prioridad_id)
                ->get();

            if ($Obj->count() <= 0) {
                $Item->prioridades()->attach($Item->prioridad_id);
            }

            /**
             * ===========================
             * ORIGEN
             * ===========================
             */
            $Obj = DB::table('denuncia_origen')
                ->where('denuncia_id', '=', $Item->id)
                ->where('origen_id', '=', $Item->origen_id)
                ->get();

            if ($Obj->count() <= 0) {
                $Item->origenes()->attach($Item->origen_id);
            }

            /**
             * ===========================
             * DEPENDENCIA / SERVICIO / ESTATUS
             * ===========================
             */
            $Obj = DB::table('denuncia_dependencia_servicio_estatus')
                ->where('denuncia_id', '=', $Item->id)
                ->where('dependencia_id', '=', $Item->dependencia_id)
                ->where('servicio_id', '=', $Item->servicio_id)
                ->where('estatu_id', '=', $Item->estatus_id)
                ->get();

            if ($Obj->count() <= 0) {
                $Item->dependencias()->attach($Item->dependencia_id, [
                    'servicio_id'      => $Item->servicio_id,
                    'estatu_id'        => $Item->estatus_id,
                    'favorable'        => false,
                    'fecha_movimiento' => $Item->fecha_ingreso,
                    'creadopor_id'     => $user_id,
                    'observaciones'    => $Item->observaciones,
                ]);
            }

            /**
             * ===========================
             * UBICACIÓN
             * ===========================
             */
            $Obj = DB::table('denuncia_ubicacion')
                ->where('denuncia_id', '=', $Item->id)
                ->where('ubicacion_id', '=', $Item->ubicacion_id)
                ->get();

            if ($Obj->count() <= 0 && !empty($Item->ubicacion_id)) {
                $Item->ubicaciones()->attach($Item->ubicacion_id);

                $ubic = Ubicacion::find($Item->ubicacion_id);

                if ($ubic) {
                    $ubic->update([
                        'altitud'       => $Item->altitud ?? 0.00,
                        'search_google' => $Item->search_google ?? '',
                        'g_ubicacion'   => $Item->gd_ubicacion ?? '',
                    ]);
                }
            }

            /**
             * ===========================
             * SERVICIO
             * ===========================
             */
            $Obj = DB::table('denuncia_servicio')
                ->where('denuncia_id', '=', $Item->id)
                ->where('servicio_id', '=', $Item->servicio_id)
                ->get();

            if ($Obj->count() <= 0) {
                $Item->servicios()->attach($Item->servicio_id);
            }

            /**
             * ===========================
             * ESTATUS
             * ===========================
             */
            $Obj = DB::table('denuncia_dependencia_servicio_estatus')
                ->where('denuncia_id', '=', $Item->id)
                ->where('dependencia_id', '=', $Item->dependencia_id)
                ->where('servicio_id', '=', $Item->servicio_id)
                ->where('estatu_id', '=', $Item->estatus_id)
                ->get();

            if ($Obj->count() <= 0) {
                $Item->estatus()->attach($Item->estatus_id, ['ultimo' => true]);
            }

            /**
             * ===========================
             * CIUDADANO
             * ===========================
             */
            $Obj = DB::table('ciudadano_denuncia')
                ->where('denuncia_id', '=', $Item->id)
                ->where('ciudadano_id', '=', $Item->ciudadano_id)
                ->get();

            if ($Obj->count() <= 0) {
                $Item->ciudadanos()->attach($Item->ciudadano_id);
            }

            /**
             * ===========================
             * CREADO POR
             * ===========================
             */
            $Obj = DB::table('creadopor_denuncia')
                ->where('denuncia_id', '=', $Item->id)
                ->where('creadopor_id', '=', $Item->creadopor_id)
                ->get();

            if ($Obj->count() <= 0) {
                $Item->creadospor()->attach($Item->creadopor_id);
            }

            /**
             * ===========================
             * MODIFICADO POR
             * ===========================
             */
            if ($item_nuevo != null) {
                $arrMod = FuncionesController::loQueSeModifico($Item, $item_viejito, $item_nuevo);

                if (
                    $arrMod['campos_modificados'] !== '' &&
                    $arrMod['antes'] !== '' &&
                    $arrMod['despues'] !== ''
                ) {
                    $Item->modificadospor()->attach($Item->modificadopor_id, [
                        'campos_modificados' => $arrMod['campos_modificados'],
                        'antes'              => $arrMod['antes'],
                        'despues'            => $arrMod['despues'],
                    ]);
                }
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }

        return $Item;
    }
}
