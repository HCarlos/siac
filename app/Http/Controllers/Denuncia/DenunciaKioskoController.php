<?php

namespace App\Http\Controllers\Denuncia;

use App\Classes\Denuncia\VistaDenunciaClass;
use App\Classes\FiltersRules;
use App\Events\IUQDenunciaEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Requests\Denuncia\DenunciaAmbitoRequest;
use App\Http\Requests\Denuncia\DenunciaKioskoRequest;
use App\Http\Requests\Denuncia\DenunciaRequest;
use App\Http\Requests\Denuncia\SearchIdenticalAmbitoRequest;
use App\Http\Requests\Denuncia\SearchIdenticalRequest;
use App\Models\Catalogos\CentroLocalidad;
use App\Models\Catalogos\Dependencia;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\Models\Catalogos\Estatu;
use App\Models\Catalogos\Origen;
use App\Models\Catalogos\Prioridad;
use App\Models\Catalogos\Servicio;
use App\Models\Catalogos\ServicioCategoria;
use App\Models\Denuncias\_viDDSs;
use App\Models\Denuncias\_viDepDenServEstatus;
use App\Models\Denuncias\_viServicios;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Firma;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;


class DenunciaKioskoController extends Controller{

    protected function createItemKiosko(DenunciaKioskoRequest $request){
        try {
            $item = $request->manage();
            return response()->json([
                'message' => 'OK',
                'data' => $item,
                'status' => 200
            ], 200);

        } catch (\Exception $e) {
            return $request->handleException($e);
        }
    }


}
