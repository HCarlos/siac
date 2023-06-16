<?php

namespace App\Listeners\User;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogLastLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event){
        if ( Auth::user() ) {
            $fecha = Carbon::now();
            Auth::user()->update(['logged' => true, 'logged_at' => $fecha]);
            Log::info("El usuario {$event->user->username} se ha logueado");
        }
    }

}
