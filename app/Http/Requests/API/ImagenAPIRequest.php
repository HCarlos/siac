<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\API;

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Classes\MessageAlertClass;
use App\Events\APIDenunciaEvent;
use App\Events\DenunciaUpdateStatusGeneralEvent;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Imagene;
use App\User;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImagenAPIRequest extends FormRequest
{




    protected $disk = 'denuncia';
    protected $F;

    public function authorize()
    {
        return true;
    }

    public function rules(){
        return [];
    }

    public function manage(){
        $this->F = new FuncionesController();

        try {

            $img = $this->manageImage();
            $this->attaches($img);
            event(new APIDenunciaEvent($this->denuncia_id, $this->user_id));

        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            return $Msg->Message($e);
        }
        return $img;

    }


    public function attaches($img){

        $img->users()->attach($this->user_id);
        $den = Denuncia::find($this->denuncia_id);
        $den->imagenes()->attach($img->id);
        return $img;

    }


    public function manageImage(){

        $this->F = new FuncionesController();

        try {

            // datos que trae el request

//            print('📦 PAYLOAD:');
//            print('  user_id: $userId');
//            print('  denuncia_id: ${request.solicitudId}');
//            print('  dependencia_id: ${request.dependenciaId}');
//            print('  estatus_id: ${request.estatusId}');
//            print('  servicio_id: ${request.servicioId}');
//            print('  latitud: ${request.latitud ?? "vacío"}');
//            print('  longitud: ${request.longitud ?? "vacío"}');
//            print('  solo_imagen: ${request.soloImagen ? 1 : 0}');

            $image = $this->imagen;
            $imageContent = $this->imageBase64Content($image);

            $file = $imageContent;
            $randomImageNameSingular = $this->randomImageNameSingular();
            $fileName = $randomImageNameSingular.'_'.$this->denuncia_id.'.png';
            $thumbnail = '_thumb_'.$randomImageNameSingular.'_'.$this->denuncia_id.'.png';
            Storage::disk($this->disk)->put($fileName, $file );
            $this->F->fitImage( $file, $thumbnail, 128, 128, true, $this->disk,"DENUNCIA_ROOT", "png" );

            $fechaActual = Carbon::now()->format('Y-m-d h:m:s');
            $user = User::find($this->user_id);

            $Item = [
                'fecha'          => $fechaActual,
                'root'           => config('atemun.public_url'),
                'image'          => $fileName,
                'image_thumb'    => $thumbnail,
                'titulo'         => 'desde la App del Operador',
                'descripcion'    => 'enviado por '.$user->full_name,
                'momento'        => 'DESPUÉS',
                'user__id'       => $this->user_id,
                'denuncia__id'   => $this->denuncia_id,
                'latitud'        => $this->latitud ?? 0,
                'longitud'       => $this->longitud ?? 0,
            ];

            $img = Imagene::create($Item);

            $Item = Denuncia::find($this->denuncia_id);

            if ($this->solo_imagen === 1){

                $trigger_type = 0;
                $user = User::find($this->user_id);
                $Obj = DB::table('denuncia_dependencia_servicio_estatus')
                    ->where('denuncia_id','=',$this->denuncia_id)
                    ->where('dependencia_id','=',$this->dependencia_id)
                    ->where('servicio_id','=',$this->servicio_id)
                    ->where('estatu_id','=',$this->estatus_id)
                    ->get();
                if ($Obj->count() <= 0 ) {
                    $Objx = $Item->dependencias()->attach($this->dependencia_id,
                        [
                            'servicio_id' => $this->servicio_id,
                            'estatu_id' => $this->estatus_id,
                            'favorable' => false,
                            'fecha_movimiento' => now(),
                            'creadopor_id' => $this->user_id,
                            'observaciones' => 'Desde la App del Operador. fue atendido por '.$user->full_name." se adjunta imagen como evidencia.",
                        ]
                    );
                    $vid = new VistaDenunciaClass();
                    $vid->vistaDenuncia($Item->id);
                    event(new DenunciaUpdateStatusGeneralEvent($Item->id,$this->user_id,$trigger_type));
                }

            }

            return $img;

        }catch (Exception $e){
            return ["status"=>0, "msg"=>$e->getMessage()];
        }
        return $user;


    }


    private function imageBase64Content($image) {
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        return base64_decode($image);

    }

    private function randomImageName() {
        return Str::random(10) . '.' . 'png';
    }

    private function randomImageNameSingular() {
        return Str::random(25) ;
    }




}
