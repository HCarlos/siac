<?php

namespace App\Notifications;

use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class SendEmailAPIVerificationNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;
    protected $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token=null){
        $this->token = $token;
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
    public function toMail($notifiable){
        $verificationAPIUrl = $this->verificationAPIUrl($notifiable);
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationAPIUrl);
        }
        return (new MailMessage)
            ->bcc(['chidalgor1971@gmail.com'])
            ->subject(Lang::get(config('atemun.app_name_short').' - Verificar dirección de correo'))
            ->line(Lang::get('Por favor, haz click en el botón de verificación de correo cuando hayas ingresado al sistema.'))
            ->line(Lang::get('Para ingresar por primera vez, debe utilizar la CURP que proporcionó tanto en el campo "Username" como en el campo "Password". Posteriormente puede cambiar su password si así lo desea.'))
            ->action(Lang::get('Verificar dirección de correo'), $verificationAPIUrl)
            ->line(Lang::get('Para validar tu correo, primero debes ingresar al sistema y posteriormente hacer click en el botón de arriba.'))
            ->line(Lang::get('Si no creaste esta cuenta, no se requiere ninguna acción.'));
    }

    protected function verificationAPIUrl($notifiable)
    {
        $user_id = $notifiable->getKey();
        $hash = sha1($notifiable->getEmailForVerification());

        $user = User::find($user_id);

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        if ($user->hasVerifiedEmail()) {
            return URL::temporarySignedRoute(
            'sendVerificationAPIUrl',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 360)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                    'notifiable' => $notifiable,
                ]
            );

        }


    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable){
        return [
            //
        ];
    }

    public function getRedirect($user){
        $role1 = $user->hasRole('Administrator|SysOp|USER_OPERATOR_SIAC|USER_OPERATOR_ADMIN|ENLACE|USER_ARCHIVO_CAP|USER_ARCHIVO_ADMIN');
        $role2 = $user->hasRole('CIUDADANO|DELEGADO');
        if ($role1) {
            return '/home';
        } elseif($role2) {
            return '/home-ciudadano';
        } else {
            return '/home';
        }
    }




    public function toMailInformation($user, $notifiable){
        $User = User::find($user->id);
        return (new MailMessage)
            ->bcc(['chidalgor1971@gmail.com'])
            ->subject(Lang::get(config('atemun.app_name_short').' - Dirección de correo verificada'))
            ->line(Lang::get('Gracias por verificar tu email..'))
            ->line(Lang::get('Ya puedes ingresar al sistema con tu CURP.'))
            ->action(Lang::get('Ir a inicio'), $this->getRedirect($User))
            ->line(Lang::get('H. Ayuntamiento Constitucional de Centro.'));
    }






}
