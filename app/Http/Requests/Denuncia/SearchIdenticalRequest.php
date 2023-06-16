<?php

namespace App\Http\Requests\Denuncia;

use App\Classes\MessageAlertClass;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Denuncias\Denuncia;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class SearchIdenticalRequest extends FormRequest{

    private $data;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function manage(){
        $this->data = [];
        try {
            $descripcion  = strtoupper(trim($this->descripcion));
            $referencia   = strtoupper(trim($this->referencia));
            $ubicacion    = strtoupper(trim($this->ubicacion));
            $ubicacion_id = intval($this->ubicacion_id);
            $usuario_id   = intval($this->usuario_id);
            $servicio_id  = intval($this->servicio_id);
            $id           = intval($this->id);

            $Ubi = Ubicacion::find($ubicacion_id);

        $filters = $descripcion.' '.$referencia.' '.$ubicacion;
//        $filters = $descripcion.' '.$referencia.' '.$Ubi->colonia;
        $filters = $Ubi->calle.' '.$Ubi->colonia;
//         dd( $filters );
        $F           = new FuncionesController();
        $tsString    = $F->string_to_tsQuery($filters,' & ');

//        dd( $tsString );
            $oFilters['search'] = $tsString;
            $oFilters['servicio_id'] = $servicio_id;

        $items = Denuncia::query()
            ->filterBy($oFilters)
            ->orderBy('id')
            ->get();

//        dd($items->count());

        $this->llevarArray($items, $usuario_id);


        }catch (QueryException $e){
            $Msg = new MessageAlertClass();
            throw new HttpResponseException(response()->json( $Msg->Message($e), 422));
        }
        return $this->data;

    }

    function llevarArray($Items, $usuario_id){
        $this->data = [];
        foreach ($Items as $item) {
            if ( $item->ciudadano_id != $usuario_id || $usuario_id = 0) {
                $Ciudadano = User::find($item->ciudadano_id);
                $this->data[] = array(
                    'descripcion'      => $item->descripcion,
                    'referencia'       => $item->referencia,
                    'ubicacion'        => $item->FullUbication,
                    'ciudadano_id'     => $item->ciudadano_id,
                    'ciudadano'        => $Ciudadano->FullName,
                    'fecha'            => $item->fecha_ingreso_solicitud,
                    'ultimo_estatus'   => $item->ultimo_estatus,
                    'total_ciudadanos' => $item->ciudadanos->count() > 1 ? $item->ciudadanos->count() : "",
                    'id'               => $item->id
                );
            }
        }

//        dd( $this->data );

        return $this->data;

    }




}
