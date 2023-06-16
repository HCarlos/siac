<?php

namespace App\Listeners\User;

use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogLastLogout
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event){
        if ( Auth::user() ){
            $fecha = Carbon::now();
            User::find($event->user->id)->update(['logged'=>false,'logout_at'=>$fecha]);
            Log::info("El usuario {$event->user->username} se ha desconectado");
        }
    }
}
