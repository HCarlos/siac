<?php

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Models\Denuncias\Denuncia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Response;

class Actualizar_Estatus_General_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $dens = Denuncia::query()
            ->select('id')
            ->orderByDesc('id')
            ->get();

        $vid = new VistaDenunciaClass();

        foreach ($dens as $den) {
            try {
                $vid->vistaDenuncia($den->id);
            }catch (\Exception $e) {
                // continue
            }
        }

    }
}
