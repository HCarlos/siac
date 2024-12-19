<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailToEnlace extends Mailable{

    use Queueable, SerializesModels;

    private $mensaje;
    private $user;
    private $denuncia;
    private $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensaje, $user, $denuncia, $type){
        $this->mensaje  = $mensaje;
        $this->user     = $user;
        $this->denuncia = $denuncia;
        $this->type     = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        $fecha_creacion = Carbon::now()->format('d-m-Y H:i:s');
        return $this->view('vendor.mail.html.mailtoenlace')->with([
            'mensaje' => $this->mensaje,
            'user' => $this->user,
            'denuncia' => $this->denuncia,
            'type' => $this->type,
            'fecha_creacion' => $fecha_creacion
        ])->subject("SIAC - Notificación Importante");
    }
}
