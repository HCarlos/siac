<?php
/*
 * Copyright (c) 2023. Realizado por Carlos Hidalgo
 */

namespace App\Http\Requests\Denuncia;

use App\Classes\MessageAlertClass;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\Denuncia;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Session;

class SearchIdenticalAmbitoRequest extends FormRequest{

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
//        dd($this->all());
        try {
            $descripcion        = strtoupper(trim($this->descripcion));
            $referencia         = strtoupper(trim($this->referencia));
            $ubicacion          = strtoupper(trim($this->ubicacion));
            $search_google      = $this->search_google;
            $searchgoogleresult = $this->searchgoogleresult;
            $ubicacion_id       = (int) $this->ubicacion_id;
            $usuario_id         = (int) $this->usuario_id;
            $servicio_id        = (int) $this->servicio_id;
            $id                 = (int) $this->id;

            $ambito_dependencia = Session::get('ambito_dependencia');
//            dd($search_google);

            if ($ambito_dependencia === 1 ){
                $Ubi = Ubicacion::find($ubicacion_id);
//                $filters = $descripcion.' '.$referencia.' '.$ubicacion;
                $filters = $Ubi->calle ?? ''.' '.$Ubi->colonia ?? '';
            }else{
//                $filters = $descripcion.' '.$referencia;
                $filters = $search_google.' '.$searchgoogleresult;
            }

            $F           = new FuncionesController();
            $tsString    = $F->string_to_tsQuery($filters,' & ');

            $oFilters['search'] = $tsString;
            $oFilters['servicio_id'] = $servicio_id;

//            dd($oFilters);
            if ($ambito_dependencia === 1 ){
                $items = _viDDSs::query()
                    ->filterBy($oFilters)
                    ->orderBy('id')
                    ->get();
            }else{
                $items = _viDDSs::query()
                    ->ambitoFilterBy($oFilters)
                    ->orderBy('id')
                    ->get();
            }

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
                    'denuncia'         => $item->denuncia,
                    'referencia'       => $item->referencia,
                    'ubicacion'        => $item->FullUbication,
                    'search_google'    => $item->search_google,
                    'gd_ubicacion'     => $item->gd_ubicacion,
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