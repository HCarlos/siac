<?php

namespace App\Providers;

use App\Listeners\User\LogLastLogin;
use App\Listeners\User\LogLastLogout;
use App\Models\Catalogos\Domicilios\Colonia;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\User\LogLastLogin',
        ],

        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\User\LogLastLogout',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('Colonia.updating *', function ($Item) {
            log($Item);
        });

    }
}
