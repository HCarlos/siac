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
use Exception;
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
        try {

            // manageImage() retorna un array con status/msg/urls
            $result = $this->manageImage();

            // Solo disparar el evento si la imagen se guardó correctamente
            if (isset($result['status']) && $result['status'] === 1) {
                event(new APIDenunciaEvent($this->denuncia_id, $this->user_id));
            }

        }catch (QueryException $e){
            return (new MessageAlertClass())->Message($e);
        }
        return $result;

    }


//    public function attaches($img){
//
//        $img->users()->attach($this->user_id);
//        $den = Denuncia::find($this->denuncia_id);
//        $den->imagenes()->attach($img->id);
//        return $img;
//
//    }


    public function manageImage(){

        $this->F = new FuncionesController();

        try {

            // datos que trae el request
            $imageContent = $this->imageBase64Content($this->imagen);

            $randomImageNameSingular = $this->randomImageNameSingular();
            $fileName  = $randomImageNameSingular.'_'.$this->denuncia_id.'.png';
            $thumbnail = '_thumb_'.$randomImageNameSingular.'_'.$this->denuncia_id.'.png';
            Storage::disk($this->disk)->put($fileName, $imageContent);
            $this->F->fitImage($imageContent, $thumbnail, 128, 128, true, $this->disk, "DENUNCIA_ROOT", "png");

            $fechaActual = Carbon::now()->format('Y-m-d H:i:s');
            $user = User::find($this->user_id);

            $img = Imagene::create([
                'fecha'          => $fechaActual,
                'root'           => config('atemun.public_url'),
                'image'          => $fileName,
                'image_thumb'    => $thumbnail,
                'titulo'         => 'Desde la App del Operador',
                'descripcion'    => trim($this->observaciones) === "" ? 'enviado por '.$user->full_name : trim($this->observaciones),
                'momento'        => trim($this->tipo_foto) === "antes" ? "ANTES" : "DESPUÉS",
                'user__id'       => $this->user_id,
                'denuncia__id'   => $this->denuncia_id,
                'latitud'        => $this->latitud ?? 0,
                'longitud'       => $this->longitud ?? 0,
            ]);

            // Adjuntar relaciones de imagen al usuario y a la denuncia
            $img->users()->attach($this->user_id);
            $denObj = Denuncia::find($this->denuncia_id);
            $denObj->imagenes()->attach($img->id);

            if ((int)$this->solo_imagen === 0){

                $trigger_type = 0;
                $Obj = DB::table('denuncia_dependencia_servicio_estatus')
                    ->where('denuncia_id','=',$this->denuncia_id)
                    ->where('dependencia_id','=',$this->dependencia_id)
                    ->where('servicio_id','=',$this->servicio_id)
                    ->where('estatu_id','=',$this->estatus_id)
                    ->get();
                if ($Obj->count() <= 0 ) {
                    $denObj->dependencias()->attach($this->dependencia_id,
                        [
                            'servicio_id'      => $this->servicio_id,
                            'estatu_id'        => $this->estatus_id,
                            'favorable'        => false,
                            'fecha_movimiento' => now(),
                            'creadopor_id'     => $this->user_id,
                            'observaciones'    => trim($this->observaciones).'. '."\n\nDesde la App del Operador. Fue atendida por ".$user->full_name." se adjunta imagen como evidencia.",
                        ]
                    );
                    $user->solicitudes()->detach($this->denuncia_id);
                    $vid = new VistaDenunciaClass();
                    $vid->vistaDenuncia($this->denuncia_id);
                    event(new DenunciaUpdateStatusGeneralEvent($this->denuncia_id,$this->user_id,$trigger_type));
                }

            }
            $fecha = (new Carbon($img->fecha))->format('d-m-Y H:i:s');
            $path  = "/storage/denuncia/";
            return [
                "status"        => 1,
                "msg"           => "Imagen guardada correctamente",
                "imagen_id"     => $img->id,
                "fecha"         => $fecha,
                "url_imagen"    => config("atemun.public_url").$path.$img->image,
                "url_thumb"     => config("atemun.public_url").$path.$img->image_thumb,
                "observaciones" => $img->descripcion ?? '',
                "tipo_foto"     => $img->momento === 'ANTES' ? "antes" : "despues",
                "es_eliminable" => $img->user__id === $user->id,
            ];

        }catch (Exception $e){
            return ["status"=>0, "msg"=>$e->getMessage()];
        }

    }

//    private function imageBase64Content($image) {
//        $image = str_replace('data:image/png;base64,', '', $image);
//        $image = str_replace(' ', '+', $image);
//        return base64_decode($image);
//    }


    private function imageBase64Content(string $image): string {
        // Elimina cualquier prefijo data URI (png, jpeg, webp, svg+xml, etc.)
        $image   = preg_replace('/^data:[^;]+;base64,/', '', $image) ?? $image;
        $decoded = base64_decode(str_replace(' ', '+', $image), true);
        if ($decoded === false) {
            throw new \InvalidArgumentException('La imagen no tiene un formato base64 válido.');
        }

        // Convertir a PNG garantiza que siempre se guarde como PNG real,
        // independientemente del formato original (jpeg, webp, gif, etc.)
        if (($gdImage = imagecreatefromstring($decoded)) === false) {
            throw new \InvalidArgumentException('No se pudo procesar la imagen.');
        }
        ob_start();
        imagepng($gdImage);
        $png = ob_get_clean();
        imagedestroy($gdImage);

        if ($png === false) {
            throw new \RuntimeException('Error al generar la imagen PNG.');
        }
        return $png;
    }

    private function randomImageNameSingular() {
        return Str::random(25);
    }




}
