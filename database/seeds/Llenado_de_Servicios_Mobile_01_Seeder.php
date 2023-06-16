<?php

use App\Models\Mobiles\Serviciomobile;
use Illuminate\Database\Seeder;

class Llenado_de_Servicios_Mobile_01_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        Serviciomobile::create(['servicio'=>'FUGA DE AGUA POTABLE','orden_image_mobile'=>1,'subarea_id'=>31,'area_id'=>27,'dependencia_id'=>12,'servicio_id'=>207]);
        Serviciomobile::create(['servicio'=>'ALCANTARILLADO / AGUAS NEGRAS','orden_image_mobile'=>2,'subarea_id'=>31,'area_id'=>27,'dependencia_id'=>12,'servicio_id'=>261]);
        Serviciomobile::create(['servicio'=>'SOCAVON / HUNDIMIENTO','orden_image_mobile'=>3,'subarea_id'=>31,'area_id'=>27,'dependencia_id'=>12,'servicio_id'=>269]);

        Serviciomobile::create(['servicio'=>'REPARACION DE CALLES (BACHEO)','orden_image_mobile'=>4,'subarea_id'=>2,'area_id'=>2, 'dependencia_id'=>1,'servicio_id'=>14]);
        Serviciomobile::create(['servicio'=>'ALUMBRADO PÚBLICO','orden_image_mobile'=>5,'subarea_id'=>32,'area_id'=>28, 'dependencia_id'=>13,'servicio_id'=>208]);
        Serviciomobile::create(['servicio'=>'RECOLECCIÓN DE BASURA','orden_image_mobile'=>6,'subarea_id'=>9,'area_id'=>6, 'dependencia_id'=>2,'servicio_id'=>65]);

    }
}
