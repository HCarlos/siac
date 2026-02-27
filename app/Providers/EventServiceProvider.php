<?php

namespace App\Providers;

use App\Events\DenunciaAtendidaEvent;
use App\Listeners\Denuncia\ActualizaEstadisticasDenunciaListener;
use App\Listeners\User\LogLastLogin;
use App\Listeners\User\LogLastLogout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Mapa evento → listener(s).
     *
     * @var array
     */
    protected $listen = [

        Login::class => [
            LogLastLogin::class,
        ],

        Logout::class => [
            LogLastLogout::class,
        ],

        // Calcula días ARO, actualiza promedios del servicio e inserta log
        DenunciaAtendidaEvent::class => [
            ActualizaEstadisticasDenunciaListener::class,
        ],

    ];

    /**
     * Registra cualquier otro evento de la aplicación.
     */
    public function boot()
    {
        parent::boot();

        Event::listen('Colonia.updating *', function ($Item) {
            log($Item);
        });
    }
}
