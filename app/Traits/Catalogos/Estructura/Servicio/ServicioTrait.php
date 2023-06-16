<?php
/*
 * Copyright (c) 2022. Realizado por Carlos Hidalgo
 */

namespace App\Traits\Catalogos\Estructura\Servicio;

use Illuminate\Support\Facades\Storage;

trait ServicioTrait{


    protected $disk = 'mobile_servicio';

    public function getTipoImageDenuncia($tipo=""){
        switch ($tipo){
            case 'thumb':
                return $this->filename_thumb;
                break;
            default :
                return $this->filename;
                break;
        }
    }

    // Get Image
    public function getPathImageAttribute(){
        return $this->getImage("");
    }

    // Get Image Thumbnail
    public function getPathImageThumbAttribute(){
        return $this->getImage("thumb");
    }

    public function getImage($tipoImage="thumb"){
        $ret = '/images/web/file-not-found.png';
        $path = config('atemun.public_url');
        $root = trim($this->root) == "" || trim($this->root) == "NULL" || is_null($this->root) ? $path : $this->root;
        $fl   = explode('.',$this->filename);
        $dg   = $fl[count($fl)-1];
//        dd($dg);
        $flDoc = config("atemun.document_type_extension");
        $flImg = config("atemun.images_type_extension");
        if ( in_array( $dg, $flDoc ) ) {
            $ret = $root.'/images/web/document-file.png';
            $tFile = $this->getTipoImageDenuncia($tipoImage);
            $exists = Storage::disk($this->disk)->exists($tFile);
            $ret = $exists
                ? "/storage/".$this->root."/".$tFile
                : $ret;
        }elseif (in_array( $dg, $flImg ) ) {
            $tFile = $this->getTipoImageDenuncia($tipoImage);
            $exists = Storage::disk($this->disk)->exists($tFile);
            $ret = $exists
                ? "/storage/".$this->root."/".$tFile
                : $ret;
        }else{
            $ret = $root.'/images/web/file-not-found.png';
        }
        return $ret;

    }


}
