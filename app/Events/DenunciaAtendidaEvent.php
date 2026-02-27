<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DenunciaAtendidaEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Propiedades públicas disponibles para listeners y broadcastWith().
     * msg e icon son llenadas por ActualizaEstadisticasDenunciaListener
     * antes de que se procese el broadcast.
     */
    public $denuncia_id;
    public $user_id;
    public $trigger_type;
    public $estatus_id;
    public $onFly;
    public $viDen;
    public $msg  = '';
    public $icon = '';
    public $status;

    /**
     * Crea una nueva instancia del evento.
     */
    public function __construct($denuncia_id, $user_id, $trigger_type, $estatus_id, $onFly, $viDen)
    {
        $this->denuncia_id  = (int) $denuncia_id;
        $this->user_id      = (int) $user_id;
        $this->trigger_type = (int) $trigger_type;
        $this->estatus_id   = (int) $estatus_id;
        $this->onFly        = $onFly;
        $this->viDen        = $viDen;
    }

    /**
     * Canal de broadcast del evento.
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-update-denuncia-estatus-atendida');
    }

    /**
     * Nombre del evento en el canal.
     */
    public function broadcastAs(): string
    {
        return 'DenunciaAtendidaEvent';
    }

    /**
     * Payload enviado al canal WebSocket.
     * Los campos msg e icon son calculados previamente por
     * ActualizaEstadisticasDenunciaListener (se ejecuta antes que el broadcast).
     *
     * @throws \JsonException
     */
    public function broadcastWith(): array
    {
        if (empty($this->msg)) {
            return [];
        }

        return [
            'denuncia_id'  => $this->denuncia_id,
            'user_id'      => $this->user_id,
            'trigger_type' => $this->trigger_type,
            'msg'          => $this->msg,
            'icon'         => $this->icon,
            'status'       => $this->status,
        ];
    }
}
