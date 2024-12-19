<?php

namespace App\Events;

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Mail\SendMailToEnlace;
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

class DenunciaUpdateStatusGeneralEvent  implements ShouldBroadcast{

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
        return new PrivateChannel('channel-update-denuncia_estatus-general');
//        return ['channel-update-denuncia_estatus-general'];
    }

    public function broadcastAs(): string{
        return 'DenunciaUpdateStatusGeneralEvent';
    }

    private function sendMailToEnlace($type){

        $den = Denuncia::find($this->denuncia_id);

//        dd($this->status_old.' - '.$den->ue_id);

        if( $this->status_old === $den->ue_id ){
            return false;
        }

        $usuariosEnlace = User::whereHas('roles', function ($query) {
            return $query->where('name', 'ENLACE');
        })
            ->whereHas('dependencias', function ($query) use ($den) {
                return $query->where('dependencia_id', $den->due_id);
            })
            ->get();

        $fecha = Carbon::now()->format('d-m-Y H:i:s');
        $msg2 = "La solicitud **".$den->id."** ";
        if ($type === 0){
            $msg2 .= " se ha **CREADO** con fecha: ".$fecha;
        }else if ($type === 1){
            $msg2 .= " ha **CAMBIADO** de **ESTATUS** a : **".$den->ultimo_estatus.'** con fecha '.$den->fecha_ultimo_estatus;
        }else if ($type === 2){
            $msg2 .= " ha sido **Eliminada** por: ".Auth::user()->fullName;
        }else{
            $msg2 = "Hubo un Problema";
        }
        //dd($usuariosEnlace);
        foreach ($usuariosEnlace as $usuario) {
            try {
                Mail::to($usuario->email)
                    ->bcc("manager@tabascoweb.com")
                    ->send(new SendMailToEnlace(
                            $msg2,
                            $usuario,
                            $den,
                            $type
                        )
                    );

            } catch (\Exception $e) {
                dd($e);
            }
        }

    }



    public function broadcastWith(): array{
        $den = Denuncia::find($this->denuncia_id);
        $this->status_old = $den->estatus_id;

        $vid = new VistaDenunciaClass();
        $vid->vistaDenuncia($this->denuncia_id);

        $this->status = 200;
        $fecha = Carbon::now()->format('d-m-Y H:i:s');

        $triger_status = "CREAR";
        if ($this->trigger_type===0){
            $this->msg    =  strtoupper(Auth::user()->FullName)." ha CREADO una nueva denuncia: ".$this->denuncia_id."  ".$fecha." con Estatus General Nuevo";
            $this->icon   = "success";
        }else if ($this->trigger_type===1){
            $this->msg    = strtoupper(Auth::user()->FullName)." ha MODIFICADO la denuncia: ".$this->denuncia_id."  ".$fecha." con Estatus General Modificado";
            $this->icon   = "info";
            $triger_status = "MODIFICAR";
        }else if ($this->trigger_type===2){
            $this->msg    = strtoupper(Auth::user()->FullName)." ha ELIMINADO la denuncia: ".$this->denuncia_id."  ".$fecha;
            $this->icon   = "warning";
            $triger_status = "ELIMINAR";
        }else{
            $this->msg    = "Hubo un Problema";
            $this->icon   = "error";
            $this->status = 204;
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        Log::alert("Evento: ".$this->msg);

        $this->sendMailToEnlace($this->trigger_type);

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
