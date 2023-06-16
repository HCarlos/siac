<?php
/**
 * Created by PhpStorm.
 * User: devch
 * Date: 30/11/18
 * Time: 10:45 AM
 */

namespace App\Traits\Catalogos;


use App\Models\Catalogos\Estatu;

trait DependenciaTraits
{

    // Varifica si una Dependencia contiene un Estatus
    public function hasEstatus($status): bool{
        if (is_string($status) && false !== strpos($status, '|')) {
            $status = $this->convertStringToArray($status);
        }

        if (is_string($status)) {
            return $this->estatus->contains('estatus', $status);
        }

        if (is_int($status)) {
            return $this->estatus->contains('id', $status);
        }

        if ($status instanceof Estatu) {
            return $this->estatus->contains('id', $status->id);
        }

        if (is_array($status)) {
            foreach ($status as $estatu) {
                if ($this->hasEstatus($estatu)) return true;
            }
            return false;
        }
        return $status->intersect($this->estatus)->isNotEmpty();
    }

    // Coverte un String a un Array
    protected function convertStringToArray(string $pipeString){
        $pipeString = trim($pipeString);
        if (strlen($pipeString) <= 2) return $pipeString;

        $quoteCharacter = substr($pipeString, 0, 1);
        $endCharacter = substr($quoteCharacter, -1, 1);

        if ($quoteCharacter !== $endCharacter) {
            return explode('|', $pipeString);
        }

        if (! in_array($quoteCharacter, ["'", '"'])) {
            return explode('|', $pipeString);
        }
        return explode('|', trim($pipeString, $quoteCharacter));
    }








}
