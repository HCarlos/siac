<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
class UbicacionUnica implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $req;
    public function __construct(FormRequest $req)
    {
        $this->req  = $req;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
//        return  Rule::unique('ubicaciones')
//            ->where('calle_id', $this->req->calle_id)
//            ->where('colonia_id', $this->req->colonia_id)
//            ->where('localidad_id', $this->req->localidad_id)
//            ->where('ciudad_id', $this->req->ciudad_id)
//            ->where('municipio_id', $this->req->municipio_id)
//            ->where('estado_id', $this->req->estado_id);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.longitud');
    }
}
