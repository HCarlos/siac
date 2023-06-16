<?php
/**
 * Copyright (c) 2019. Realizado por Carlos Hidalgo
 */

/**
 * Created by PhpStorm.
 * User: devch
 * Date: 14/03/19
 * Time: 11:51 AM
 */

namespace App\Traits\Denuncia;


use App\Http\Controllers\Funciones\FuncionesController;
use Illuminate\Support\Facades\Storage;

trait ImagenMobileTrait
{

    protected $disk = 'mobile_denuncia';

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
        $flImg = config("atemun.images_type_extension");
        if (in_array( $dg, $flImg ) ) {
            $tFile = $this->getTipoImageDenuncia($tipoImage);
            $exists = Storage::disk($this->disk)->exists($tFile);
            $ret = $exists
                ? "/storage/mobile/denuncia/".$tFile
                : $ret;
        }else{
            $ret = $root.'/images/web/file-not-found.png';
        }
        return $ret;

    }



}
