<?php

namespace App\Mail;

use App\View\Components\Denuncia;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class SendMailToEnlace extends Mailable{

    use Queueable, SerializesModels;

    private $mensaje;
    private $user;
    private $denuncia;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensaje, $user, $denuncia){
        $this->mensaje  = $mensaje;
        $this->user     = $user;
        $this->denuncia = $denuncia;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){

//        return (new MailMessage)
//            ->subject('SIAC - Notificación Importante')
//            ->line($this->mensaje)
//            ->action('Ver estatus', url('/listDenunciaDependenciaServicioAmbito/'.$this->denuncia->id))
//            ->line('¡Gracias por usar nuestra aplicación!');



        return $this->view('vendor.mail.html.mailstoenlace',
            [
                'mensaje' => $this->mensaje,
                'user' => $this->user,
                'denuncia' => $this->denuncia,
            ]
        );

    }
}
