<?php
/*
 * Listener que calcula y persiste las estadísticas de tiempo (días atendida,
 * rechazada u observada) y actualiza el promedio del servicio correspondiente
 * cuando una denuncia cambia a estatus 17 (ATENDIDA), 20 (RECHAZADA) o 18 (OBSERVADA).
 *
 * Se ejecuta síncronamente al despachar DenunciaAtendidaEvent, ANTES de que
 * broadcastWith() arme el payload de WebSocket. Así broadcastWith() solo
 * serializa datos ya calculados.
 */

namespace App\Listeners\Denuncia;

use App\Classes\Denuncia\ActualizaEstadisticasARO;
use App\Events\DenunciaAtendidaEvent;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\Denuncia;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ActualizaEstadisticasDenunciaListener
{
    public function __construct() {}

    /**
     * Maneja el evento DenunciaAtendidaEvent.
     * Solo actúa sobre los estatus 17 (ATENDIDA), 20 (RECHAZADA) y 18 (OBSERVADA).
     *
     * @param DenunciaAtendidaEvent $event
     * @return void
     */
    public function handle(DenunciaAtendidaEvent $event): void
    {
        if (!in_array($event->estatus_id, [17, 18, 20])) {
            return;
        }

        $den = Denuncia::find($event->denuncia_id);
        if (!$den) {
            return;
        }

        // Calcular semáforo
        // onFly=true  → llamada en tiempo real desde el request web ($viDen = null)
        // onFly=false → llamada desde command/batch ($viDen = registro DDSE)
        if ($event->onFly) {
            // $den->ue_id        → entero (no la relación ultimo_estatus que devuelve el modelo Estatu)
            // $den->fecha_ultimo_estatus → string en DB, se envuelve en DateTime igual que Denuncia::semaforo_ultimo_estatus()
            // $den->fecha_ingreso        → Carbon (está en $dates del modelo)
            $semaforo = ActualizaEstadisticasARO::semaforo_ultimo_estatus_off(
                $den->ue_id,
                new DateTime($den->fecha_ultimo_estatus),
                $den->fecha_ingreso
            );
        } else {
            $semaforo = ActualizaEstadisticasARO::semaforo_ultimo_estatus_off(
                $event->viDen->estatu_id,
                $event->viDen->fecha_movimiento,
                $den->fecha_ingreso
            );
        }

        // Actualizar campo de días en la denuncia, calcular promedio del servicio
        // y determinar etiqueta para el mensaje — usando elseif para garantizar
        // que $lblEstatus siempre quede definida antes del bloque de log.
        if ($event->estatus_id === 17) {          // ATENDIDA

            $den->dias_atendida = $semaforo['dias'];
            $den->save();

            $pdx = DB::table('denuncias')
                ->select(DB::raw('AVG(COALESCE(dias_atendida)) AS promedio_dias_atendida'))
                ->where('servicio_id', $den->servicio_id)
                ->where('dias_atendida', '>', 0)
                ->groupBy('servicio_id')
                ->first();

            if ($pdx !== null && $pdx->promedio_dias_atendida !== null) {
                $Ser = Servicio::find($den->servicio_id);
                $Ser->promedio_dias_atendida = $pdx->promedio_dias_atendida;
                $Ser->save();
            }

            $lblEstatus = 'ATENDIDA';

        } elseif ($event->estatus_id === 20) {    // RECHAZADA

            $den->dias_rechazada = $semaforo['dias'];
            $den->save();

            $pdx = DB::table('denuncias')
                ->select(DB::raw('AVG(COALESCE(dias_rechazada)) AS promedio_dias_rechazada'))
                ->where('servicio_id', $den->servicio_id)
                ->where('dias_rechazada', '>', 0)
                ->groupBy('servicio_id')
                ->first();

            if ($pdx !== null && $pdx->promedio_dias_rechazada !== null) {
                $Ser = Servicio::find($den->servicio_id);
                $Ser->promedio_dias_rechazada = $pdx->promedio_dias_rechazada;
                $Ser->save();
            }

            $lblEstatus = 'RECHAZADA';

        } else {                                  // 18 - OBSERVADA

            // Bug corregido: el original guardaba en dias_rechazada por error
            $den->dias_observada = $semaforo['dias'];
            $den->save();

            $pdx = DB::table('denuncias')
                ->select(DB::raw('AVG(COALESCE(dias_observada)) AS promedio_dias_observada'))
                ->where('servicio_id', $den->servicio_id)
                ->where('dias_observada', '>', 0)
                ->groupBy('servicio_id')
                ->first();

            if ($pdx !== null && $pdx->promedio_dias_observada !== null) {
                $Ser = Servicio::find($den->servicio_id);
                $Ser->promedio_dias_observada = $pdx->promedio_dias_observada;
                $Ser->save();
            }

            $lblEstatus = 'OBSERVADA';
        }

        // Armar mensaje para broadcast y log
        $user  = User::find($event->user_id);
        $fecha = Carbon::now()->format('d-m-Y H:i');
        $event->msg  = strtoupper($user->FullName) . ' ha marcado como ' . $lblEstatus
                       . ' la solicitud: ' . $event->denuncia_id . '  ' . $fecha;
        $event->icon = 'primary';

        // ip: igual que el original, siempre llama FuncionesController::getIp()
        // host: $_SERVER cuando es request web, '0.0.0.0' cuando es command/batch
        $host = '0.0.0.0';
        if ($event->onFly) {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $host = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $host = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
                $host = $_SERVER['REMOTE_ADDR'];
            }
        }

        Log::alert('Evento: ' . $event->msg);

        DB::table('logs')->insert([
            'model_name'     => 'denuncias',
            'model_id'       => $event->denuncia_id,
            'trigger_status' => 1,
            'trigger_type'   => $event->trigger_type,
            'message'        => $event->msg,
            'icon'           => $event->icon,
            'status'         => 200,
            'ip'             => FuncionesController::getIp(), // igual que el original: siempre
            'host'           => $host,
            'fecha'          => now(),
            'user_id'        => $event->user_id,
        ]);
    }
}
