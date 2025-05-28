<?php

namespace App\Events;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Estatu;
use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeStatusEvent  implements ShouldBroadcast{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $denuncia_id, $user_id, $trigger_type, $msg, $icon, $status, $estatus_id, $onFly, $viDen, $id, $power;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($denuncia_id, $estatus_id, $id, $trigger_type){
        $this->id = $id;
        $this->denuncia_id = $denuncia_id;
        $this->user_id = 0;
        $this->status = "";
        $this->estatus_id = $estatus_id;
        $this->trigger_type = $trigger_type;
        $this->onFly = false;
        $this->viDen = false;
        $this->msg = '';
        $this->icon = 'info';
        $this->power = 10;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): array{
        return ['test-channel'];
    }

    public function broadcastAs(): string{
        return 'ChangeStatusEvent';
    }

    public function broadcastWith(): array{

        $estatus = Estatu::find($this->estatus_id);

//        dd($estatus);

        $this->status = $estatus->estatus;

        $user = Auth::user();
        $this->user_id = $user->id;
        $fecha = Carbon::now()->format('d-m-Y H:i'); //$fecha
        $this->msg    =  strtoupper($user->FullName)." ha cambiado a ".$this->status." la solicitud: ".$this->denuncia_id." | ".$fecha;
        $this->icon   = "coral";

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
            'model_name'     => 'denuncia_dependencia_servicio_estatus',
            'model_id'       => $this->id,
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
            'power'          => $this->power,
            'denuncias_hoy'  => 0,
            'porcentaje_hoy' => 0,
            'categoria_sol'  => 0,
        ];

    }




}
