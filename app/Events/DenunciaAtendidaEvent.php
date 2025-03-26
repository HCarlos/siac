<?php

namespace App\Events;

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

    public $denuncia_id, $user_id, $trigger_type, $msg, $icon, $status, $status_old;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($denuncia_id, $user_id, $trigger_type){
        $this->denuncia_id = $denuncia_id;
        $this->user_id = $user_id;
        $this->trigger_type = $trigger_type;
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
        $den = Denuncia::find($this->denuncia_id);
        $semaforo = $den->semaforo_ultimo_estatus();
        $den->dias_atendida = $semaforo['dias'];
        $den->save();


        $pdx = DB::table("denuncias")
            ->select(DB::raw("AVG(dias_atendida) AS promedio_dias_atendida"))
            ->where('servicio_id',$den->servicio_id)
            ->where('ambito_dependencia',2)
            ->where('fecha_ingreso','>','2025-03-26 00:00:00')
            ->groupBy('servicio_id')
            ->first();

        if ($pdx->promedio_dias_atendida !== null){
            Servicio::find($den->servicio_id)->update([
                'promedio_dias_atendida' => $pdx->promedio_dias_atendida,
            ]);
        }

        $fecha = Carbon::now()->format('d-m-Y H:i'); //$fecha
        $this->msg    =  strtoupper(Auth::user()->FullName)." ha marcado como ATENDIDA la solicitud: ".$this->denuncia_id."  ".$fecha;
        $this->icon   = "primary";

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        Log::alert("Evento: ".$this->msg);

        DB::table('logs')->insert([
            'model_name'     => 'denuncias',
            'model_id'       => $this->denuncia_id,
            'trigger_status' => 1,
            'trigger_type'   => $this->trigger_type,
            'message'        => $this->msg,
            'icon'           => $this->icon,
            'status'         => $this->status,
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


}
