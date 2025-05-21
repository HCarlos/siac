<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsuarioCURPController extends Controller{

    public function buscarPorCurp(Request $request, $curp = null) {

        if (!$curp) {
            $curp = $request->input('curp');
        }

        if (!$curp) {
            return response()->json([
                'error' => 'CURP no proporcionada',
                'codigo' => 400
            ], 400);
        }

        // Validar formato básico de CURP (18 caracteres)
        if (strlen($curp) !== 18) {
            return response()->json([
                'error' => 'Formato de CURP inválido',
                'codigo' => 400
            ], 400);
        }

        $usuario = User::where('curp', $curp)->first();

        if (!$usuario) {
            return response()->json([
                'error' => 'Usuario no encontrado',
                'codigo' => 404
            ], 404);
        }

        // Formato de respuesta personalizado
        return response()->json([
            'data' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'apellidos' => $usuario->ap_paterno . ' ' . $usuario->ap_materno,
                'email' => $usuario->email,
                'curp' => $usuario->curp,
                'fecha_registro' => $usuario->created_at->format('Y-m-d')
            ],
            'codigo' => 200
        ]);

    }

}
