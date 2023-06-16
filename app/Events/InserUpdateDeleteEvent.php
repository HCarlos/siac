<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Contracts\EventDispatcher\Event;
use function MongoDB\BSON\toJSON;

class InserUpdateDeleteEvent implements ShouldBroadcast{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    private $status = 0;
    private $msg = "";

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($status = 0, $msg = "" ){
        $this->data = array(
            'power'=> '10'
        );
        $this->status = $status;
        $this->msg = $msg;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(){
        $retorno = ['test-channel'];
        Log::alert("Valor de Retorno del Evento: ".json_encode($retorno));
        return $retorno;
   }

    public function broadcastAs()
    {
        return 'InserUpdateDeleteEvent';
    }

    public function broadcastWith(){
        return [
            'title'  => 'This notification from www.codecheef.org',
            'power'  => '10',
            'status' => $this->status,
            'msg'    => $this->msg,
        ];
    }

}
