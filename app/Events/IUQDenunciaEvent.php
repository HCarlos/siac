<?php

namespace App\Events;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Denuncias\Denuncia;
use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class IUQDenunciaEvent implements ShouldBroadcast{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $denuncia_id, $user_id, $trigger_type, $msg, $icon, $status, $power;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($denuncia_id, $user_id, $trigger_type){
        $this->denuncia_id  = $denuncia_id;
        $this->user_id      = $user_id;
        $this->trigger_type = $trigger_type;
        $this->status       = 204;
        $this->power        = 10;
    }

    public function broadcastOn(): array{
        return ['test-channel'];
    }

    public function broadcastAs(): string{
        return 'IUQDenunciaEvent';
    }


    public function broadcastWith(): array{

        $den = Denuncia::find($this->denuncia_id);
        $ad = (int) ($den->dependencia->ambito_dependencia ?? 1); //$den->dependencia->ambito_dependencia ?? 1;

        $this->status = 200;
        $fecha = Carbon::now()->format('d-m-Y H:i:s');
        $triger_status = "CREAR";
        if ($this->trigger_type===0){
            $this->msg    =  strtoupper(Auth::user()->FullName)." ha CREADO una nueva solicitud: ".$this->denuncia_id."  ".$fecha;
            $this->icon   = "success";
        }else if ($this->trigger_type===1){
            $this->msg    = strtoupper(Auth::user()->FullName)." ha MODIFICADO la solicitud: ".$this->denuncia_id."  ".$fecha;
            $this->icon   = "info";
            $triger_status = "MODIFICAR";
        }else if ($this->trigger_type===2){
            $this->msg    = strtoupper(Auth::user()->FullName)." ha ELIMINADO la solicitud: ".$this->denuncia_id."  ".$fecha;
            $this->icon   = "warning";
            $triger_status = "ELIMINAR";
        }else{
            $this->msg    = "Hubo un Problema";
            $this->icon   = "error";
            $this->status = 204;
            $this->trigger_type = -1;
        }
        $this->msg .=  $ad === 1 ? " | Apoyos Sociales" : " | Servicios Municipales";

        Log::alert("Evento: ".$this->msg);

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        DB::table('logs')->insert([
            'model_name'     => 'denuncias',
            'model_id'       => $this->denuncia_id,
            'trigger_status' => $triger_status,
            'trigger_type'   => $this->trigger_type,
            'message'        => $this->msg,
            'icon'           => $this->icon,
            'status'         => $this->status,
            'ip'             => FuncionesController::getIp(),
            'host'           => $ip,
            'fecha'          => now(),
            'user_id'        => $this->user_id,
        ]);


        $h1 = ' 00:00:00';
        $h2 = ' 23:59:59';

        $fa0 = Carbon::now()->format('Y-m-d');
        $fa1 = $fa0 . $h1;
        $fa2 = $fa0 . $h2;

        $fy0 = Carbon::yesterday()->format('Y-m-d');
        $fy1 = $fy0 . $h1;
        $fy2 = $fy0 . $h2;


        $DenunciasHoy = Denuncia::query()->whereBetween('fecha_ingreso',[$fa1,$fa2])->count();
        $DenunciasAyer = Denuncia::query()->whereBetween('fecha_ingreso',[$fy1,$fy2])->count();
        $porc = 0;
        if ($DenunciasAyer > 0){
            $porc = ((($DenunciasHoy / $DenunciasAyer) * 100) - 100);
        }

        return [
            'denuncia_id'    => $this->denuncia_id,
            'user_id'        => $this->user_id,
            'trigger_type'   => $this->trigger_type,
            'msg'            => $this->msg,
            'icon'           => $this->icon,
            'status'         => $this->status,
            'power'          => $this->power,
            'denuncias_hoy'  => $DenunciasHoy,
            'porcentaje_hoy' => number_format($porc, 2, '.', ','),
            'categoria_sol'  => $ad,
        ];
    }


}
