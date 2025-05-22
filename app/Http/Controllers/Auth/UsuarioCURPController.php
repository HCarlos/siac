<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsuarioCURPController extends Controller
{

    public function buscarPorCurp(Request $request, $curp = null){

        if (!$curp) {
            $curp = $request->input('curp');
        }

            // Validación de CURP
            if (strlen($curp) !== 18) {
//                return response()->json(
//                    ['mensaje' => 'CURP inválida', 'data'=>'1', 'status' => 400],
//                    Response::HTTP_BAD_REQUEST,
//                    ['Content-Type' => 'application/json;charset=UTF-8'],
//                    JSON_UNESCAPED_UNICODE
//                );
                return response()->json(['mensaje' => 'Error', 'data' => 'CURP inválida', 'status' => '422'], 200);
            }


            $usuario = User::where('curp', $curp)->first();

//            dd($usuario);

            if (!$usuario) {
//                return response()->json(
//                    ['mensaje' => 'Usuario no encontrado', 'data'=>'2', 'status' => 200],
//                    Response::HTTP_NOT_FOUND,
//                    ['Content-Type' => 'application/json;charset=UTF-8'],
//                    JSON_UNESCAPED_UNICODE
//                );
                return response()->json(['mensaje' => 'Error', 'data' => 'Usuario no encontrado', 'status' => '422'], 200);
            }

            return response()->json(
                [
                    'mensaje' => 'OK',
                    'data' => [
                        'id' => $usuario->id,
                        'nombre' => $usuario->nombre,
                        'apellidos' => $usuario->ap_paterno . ' ' . $usuario->ap_materno,
                        'email' => $usuario->email,
                        'curp' => $usuario->curp,
                        'fecha_registro' => $usuario->created_at->format('Y-m-d')
                    ],
                    'status' => 200
                ],
                200);

    }
}
