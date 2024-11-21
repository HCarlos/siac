<?php
/*
 * Copyright (c) 2024. Realizado por Carlos Hidalgo
 */

namespace App\Http\Controllers\Denuncia;

use App\Classes\RemoveItemSafe;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class DenunciaUserAmbitoController extends Controller{

    protected function showModalDenunciaUserUpdate($Id){

        $Ciudadano = User::find($Id);

//        dd($Id);

        $user = Auth::user();

        return view ('SIAC.denuncia.search_ambito.denuncia_user_modal',
            [
                'putModalDenunciaUserUpdate' => 'putModalDenunciaUserUpdate',
                'ciudadano'          => $Ciudadano,
                'items'              => $user,
                'ambito_dependencia' => FuncionesController::arrAmbitosDependencia(),

            ]
        );

    }


    // ***************** MUESTRA EL MENU DE BUSQUEDA ++++++++++++++++++++ //
    protected function putModalDenunciaUserUpdate(Request $request){

        $data = $request->all();

//        dd($data);

        $Ciudadano = User::find($data['ciudadano_id']);
        $Ciudadano->ap_paterno = $data['ap_paterno'];
        $Ciudadano->ap_materno = $data['ap_materno'];
        $Ciudadano->nombre     = $data['nombre'];
        $Ciudadano->telefonos  = $data['telefonos'];
        $Ciudadano->celulares  = $data['celulares'];
        $Ciudadano->emails     = $data['emails'];
        $Ciudadano->save();

        return Response::json(['mensaje' => 'Datos guardados con éxito', 'data' => $Ciudadano, 'status' => '200'], 200);

    }




}
