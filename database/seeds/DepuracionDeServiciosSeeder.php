<?php

use App\Models\Catalogos\Servicio;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use App\Models\Denuncias\Denuncia_Servicio;
use Illuminate\Database\Seeder;

class DepuracionDeServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

    // Primer Bloque

    $Actuales = explode(',',"1, 2, 4");
    $Nuevos   = explode(',',"454, 454, 454");
    $Quitar   = explode(',',"31852, 31850, 31847, 31777, 31693, 30447, 23803, 29723, 47111");

    $DenServ    = Denuncia_Servicio::whereIn("id",$Quitar)->forceDelete();


    $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
    $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
    $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
    $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();


        // Segundo Bloque

        $Actuales = explode(',',"3");
        $Nuevos   = explode(',',"455");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();


        // TErcer Bloque

        $Actuales = explode(',',"5, 6, 7, 8");
        $Nuevos   = explode(',',"452, 452, 452, 452");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();


        // Cuarto Bloque

        $Actuales = explode(',',"239, 403");
        $Nuevos   = explode(',',"453, 453");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();


        // Quinto Bloque

        $Actuales = explode(',',"19, 20, 21, 22, 23, 24, 25, 26, 27, 28");
        $Nuevos   = explode(',',"443, 443, 443, 443, 443, 443, 443, 443, 443, 443");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();



        // Sexto Bloque

        $Actuales = explode(',',"14, 16, 17, 18");
        $Nuevos   = explode(',',"442, 442, 442, 442");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();



        // Septimo Bloque

        $Actuales = explode(',',"9, 10, 11");
        $Nuevos   = explode(',',"456, 456, 456");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();

        // Octavo Bloque

        $Actuales = explode(',',"13, 15, 29");
        $Nuevos   = explode(',',"444, 444, 444");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();


        // Noveno Bloque

        $Actuales = explode(',',"36, 37, 38, 39, 40, 41, 42, 43, 270");
        $Nuevos   = explode(',',"445, 445, 445, 445, 445, 445, 445, 445, 445");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();


        // Decimo Bloque

        $Actuales = explode(',',"35, 44");
        $Nuevos   = explode(',',"34, 34");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();



        // Undecimo Bloque

        $Actuales = explode(',',"30, 31, 32, 33, 45, 46, 312, 331, 381");
        $Nuevos   = explode(',',"457, 457, 457, 457, 457, 457, 457, 457, 457");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();


        // Doudecimo Bloque

        $Actuales = explode(',',"47, 48, 49, 50, 52, 61, 62, 63, 302, 64, 400");
        $Nuevos   = explode(',',"446, 446, 446, 446, 446, 446, 446, 446, 446, 446, 446");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();



        // Tridecimo Bloque

        $Actuales = explode(',',"51, 53, 54, 55, 56, 57, 58, 59, 60");
        $Nuevos   = explode(',',"447, 447, 447, 447, 447, 447, 447, 447, 447");

        $Den        = Denuncia::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenServ    = Denuncia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $DenDepServ = Denuncia_Dependencia_Servicio::whereIn("servicio_id",$Actuales)->update(['servicio_id' => $Nuevos[0]]);
        $Servicios  = Servicio::whereIn("id",$Actuales)->forceDelete();



    }
}
