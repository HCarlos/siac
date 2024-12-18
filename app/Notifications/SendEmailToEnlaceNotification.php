<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class SendEmailToEnlaceNotification extends Notification
{
    use Queueable;
    private $mensaje;
    private $user;
    private $denuncia;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mensaje, $user, $denuncia){
        $this->mensaje  = $mensaje;
        $this->user     = $user;
        $this->denuncia = $denuncia;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//            ->bcc(['siac@centro.gob.mx'])
//            ->subject(Lang::get(config('atemun.app_name_short').' - Notificacin'))
//            ->line(Lang::get($this->mensaje))
//            ->action(Lang::get('Ir a inicio'), $this->getRedirect($this->user))
//            ->line(Lang::get('H. Ayuntamiento Constitucional de Centro.'));
//    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notificación Importante')
            ->line($this->mensaje)
            ->action('Ver más', url('/listDenunciaDependenciaServicioAmbito/'.$this->denuncia->id))
            ->line('¡Gracias por usar nuestra aplicación!');
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
