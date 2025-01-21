<?php

namespace App\Events;

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Mail\SendMailToEnlace;
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

class DenunciaUpdateStatusGeneralAmbitoEvent  implements ShouldBroadcast{

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

        $usuariosEnlace = User::whereHas('roles', function ($query) {
                                return $query->where('name', 'ENLACE');
                            })
                            ->whereHas('dependencias', function ($query) use ($den) {
                                return $query->where('dependencia_id', $den->due_id);
                            })
                            ->get();

//        dd($usuariosEnlace);

        foreach ($usuariosEnlace as $usuario) {
            try {
                if (
                    strpos($usuario->email, "@mail.com") === false &&
                    strpos($usuario->email, "@mail.com") === false &&
                    strpos($usuario->email, "@example.com") === false &&
                    $usuario->email !== "" &&
                    $usuario->email !== null
                ) {
                    Mail::to($usuario->email)
                        ->send(new SendMailToEnlace(
                                'Notification',
                                $usuario,
                                $den,
                                $type
                            )
                        );
                }
            } catch (\Exception $e) {
                Log::error('Error sending email in sendMailToEnlace: ' . $e->getMessage());
            }
        }
        return true;
    }


    /**
     * @throws \JsonException
     */
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
            $this->sendMailToEnlace($this->trigger_type);
        }else if ($this->trigger_type===1){
            $this->msg    = strtoupper(Auth::user()->FullName)." ha MODIFICADO la denuncia: ".$this->denuncia_id."  ".$fecha." con Estatus General Modificado";
            $this->icon   = "info";
            $triger_status = "MODIFICAR";
        }else if ($this->trigger_type===2){
            $this->msg    = strtoupper(Auth::user()->FullName)." ha ELIMINADO la denuncia: ".$this->denuncia_id."  ".$fecha;
            $this->icon   = "warning";
            $triger_status = "ELIMINAR";
            $this->sendMailToEnlace($this->trigger_type);
        }else if ($this->trigger_type===3){
            $this->msg    = strtoupper(Auth::user()->FullName)." ha CAMBIADO su ESTATUS de la denuncia: ".$this->denuncia_id."  ".$fecha." con Estatus General Modificado";
            $this->icon   = "info";
            $triger_status = "MODIFICAR";
            $this->sendMailToEnlace($this->trigger_type);
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
