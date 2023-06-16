<?php

namespace App\Observers\Catalogos\Estatu;

use App\Models\Catalogos\Estatu;
use Illuminate\Support\Facades\Log;

class PostUpdating
{
    public static function updating(Estatu $status){
        Log::info("El estatus {$status->estatus} se ha actualizado");
    }
}
