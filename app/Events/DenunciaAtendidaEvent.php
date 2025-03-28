<?php

namespace App\Events;

use App\Classes\Denuncia\ActualizaEstadisticasARO;
use App\Classes\Denuncia\VistaDenunciaClass;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Mail\SendMailToEnlace;
use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\Denuncia;
use App\User;
use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DenunciaAtendidaEvent  implements ShouldBroadcast{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $denuncia_id, $user_id, $trigger_type, $msg, $icon, $status, $estatus_id, $onFly, $viDen;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($denuncia_id, $user_id, $trigger_type, $estatus_id, $onFly, $viDen) {
        $this->denuncia_id = (int) $denuncia_id;
        $this->user_id = (int) $user_id;
        $this->trigger_type = (int) $trigger_type;
        $this->estatus_id = (int) $estatus_id;
//        dd($this->estatus_id);
//        dd($viDen);
        $this->onFly = $onFly;
        $this->viDen = $viDen;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-update-denuncia-estatus-atendida');
    }

    public function broadcastAs(): string {
        return 'DenunciaAtendidaEvent';
    }


    /**
     * @throws \JsonException
     */
    public function broadcastWith(): array{


        if ( in_array($this->estatus_id, [17,20])) {

            if ($this->estatus_id == 17) { // ATENDIDA

                $den = Denuncia::find($this->denuncia_id);
                if ($this->onFly){
                    $semaforo = $den->semaforo_ultimo_estatus();
                }else{
                    $aro = new ActualizaEstadisticasARO($this->denuncia_id);
                    $semaforo = $aro->semaforo_ultimo_estatus_off($den,$this->viDen);
                }
                $den->dias_atendida = $semaforo['dias'];
                $den->save();

                $pdx = DB::table("denuncias")
                    ->select(DB::raw("AVG(dias_atendida) AS promedio_dias_atendida"))
                    ->where('servicio_id', $den->servicio_id)
                    ->where('dias_atendida','>', 0)
                    ->groupBy('servicio_id')
                    ->first();

//                ->where('ambito_dependencia', 2)

                if ($pdx->promedio_dias_atendida !== null) {
//                    Servicio::find($den->servicio_id)->update([
//                        'promedio_dias_atendida' => $pdx->promedio_dias_atendida,
//                    ]);
                    $Ser = Servicio::find($den->servicio_id);
                    $Ser->promedio_dias_atendida = $pdx->promedio_dias_atendida;
                    $Ser->save();

                }
                $lblEstatus = "ATENDIDA";
            }

            if ($this->estatus_id == 20) { // RECHAZADA

                $den = Denuncia::find($this->denuncia_id);
                if ($this->onFly){
                    $semaforo = $den->semaforo_ultimo_estatus();
                }else{
                    $aro = new ActualizaEstadisticasARO($this->denuncia_id);
                    $semaforo = $aro->semaforo_ultimo_estatus_off($den,$this->viDen);
                }
                $den->dias_rechazada = $semaforo['dias'];
                $den->save();

                $pdx = DB::table("denuncias")
                    ->select(DB::raw("AVG(dias_rechazada) AS promedio_dias_rechazada"))
                    ->where('servicio_id', $den->servicio_id)
                    ->where('dias_rechazada','>', 0)
                    ->groupBy('servicio_id')
                    ->first();

//                ->where('ambito_dependencia', 2)

//                if ($pdx->promedio_dias_rechazada !== null) {
                    $Ser = Servicio::find($den->servicio_id);
                    $Ser->promedio_dias_rechazada = $pdx->promedio_dias_rechazada;
                    $Ser->save();
//                }

                $lblEstatus = "RECHAZADA";

//                dd($lblEstatus);

            }

            $user = User::find($this->user_id);
            $fecha = Carbon::now()->format('d-m-Y H:i'); //$fecha
            $this->msg    =  strtoupper($user->FullName)." ha marcado como ".$lblEstatus." la solicitud: ".$this->denuncia_id."  ".$fecha;
            $this->icon   = "primary";

            if ($this->onFly){
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            }else{
                $ip = "0.0.0.0";
            }

            Log::alert("Evento: ".$this->msg);

            DB::table('logs')->insert([
                'model_name'     => 'denuncias',
                'model_id'       => $this->denuncia_id,
                'trigger_status' => 1,
                'trigger_type'   => $this->trigger_type,
                'message'        => $this->msg,
                'icon'           => $this->icon,
                'status'         => 200,
                'ip'             => FuncionesController::getIp(),
                'host'           => $ip,
                'fecha'          => now(),
                'user_id'        => $this->user_id,
            ]);

            return [
                'denuncia_id'    => $this->denuncia_id,
                'user_id'        => $this->user_id,
                'trigger_type'   => $this->trigger_type,
                'msg'            => $this->msg,
                'icon'           => $this->icon,
                'status'         => $this->status,
            ];
        }

        return [];

    }

}
