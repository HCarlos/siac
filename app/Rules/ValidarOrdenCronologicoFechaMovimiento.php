<?php

namespace App\Rules;

use App\Models\Denuncias\Denuncia_Dependencia_Servicio;
use Illuminate\Contracts\Validation\Rule;

class ValidarOrdenCronologicoFechaMovimiento implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($id, $value){
        $validacion = Denuncia_Dependencia_Servicio::validarOrdenCronologicoFechaMovimiento(
            $id,
            $value,
            true
        );

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
