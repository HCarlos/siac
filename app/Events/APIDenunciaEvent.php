<?php

namespace App\Events;

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Mobiles\Denunciamobile;
use App\User;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class APIDenunciaEvent  implements ShouldBroadcast {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $denuncia_id, $user_id, $msg, $icon, $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($denuncia_id, $user_id){
        $this->denuncia_id  = $denuncia_id;
        $this->user_id      = $user_id;
        $this->status       = 200;
    }

    public function broadcastOn(){
        return ['api-channel'];
    }

    public function broadcastAs()
    {
        return 'APIDenunciaEvent';
    }

    /**
     * @throws \JsonException
     */
    public function broadcastWith(){
        $this->status = 200;
        $fecha = Carbon::now()->format('d-m-Y H:i:s');
        $user = User::find($this->user_id);
        $this->msg    =  strtoupper($user->FullName)." ha CREADO una nueva denuncia mobile: ".$this->denuncia_id."  ".$fecha;
        $this->icon   = "success";
        $triger_status = "CREAR";

        Log::alert("Evento Mobile: ".$this->msg);

        $Obj = DB::table('logs')->insert([
            'model_name'     => 'denuncias_mobile',
            'model_id'       => $this->denuncia_id,
            'trigger_status' => $triger_status,
            'trigger_type'   => 0,
            'message'        => $this->msg,
            'icon'           => $this->icon,
            'status'         => $this->status,
            'ip'             => 'Mobile',
            'host'           => 'Mobile',
            'fecha'          => now(),
            'user_id'        => $this->user_id,
        ]);

        $DenMob = Denunciamobile::find($this->denuncia_id);

        $vid = new VistaDenunciaClass();
        $vid->vistaDenuncia($this->denuncia_id);

        return [
            'denuncia_id'  => $this->denuncia_id,
            'user_id'      => $this->user_id,
            'msg'          => $this->msg,
            'icon'         => $this->icon,
            'status'       => $this->status,
            'power'        => 10,
        ];


    }



}
