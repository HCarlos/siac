<?php
/**
 * CentroBotController.php
 *
 * Controlador para integraciones con el CentroBot (WhatsApp u otros canales externos).
 * Genera URLs públicas únicas para que el ciudadano interactúe con sus solicitudes
 * sin necesidad de autenticación.
 *
 * Namespace: App\Http\Controllers\CentroBot
 */

namespace App\Http\Controllers\CentroBot;

use App\Http\Controllers\Controller;
use App\Models\Denuncias\Denuncia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CentroBotController extends Controller
{
    /**
     * Genera una URL pública única para que el ciudadano suba fotos de una solicitud.
     *
     * Parámetro GET esperado:
     *   - solicitud_id (int, requerido) — ID (folio) de la solicitud/denuncia
     *
     * Protección contra inyección SQL:
     *   - Laravel Validation garantiza que el valor sea entero ≥ 1 antes de llegar a la DB.
     *   - Eloquent::find() usa PDO con consultas parametrizadas (prepared statements).
     *
     * Respuesta JSON:
     *   { status: bool, mensaje: string, url: string }
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function generarUrlSubidaFotos(Request $request): JsonResponse
    {
        // Validación de entrada: entero positivo obligatorio.
        // Cualquier valor no entero o fuera de rango provoca un 422 automáticamente.
        $datos = $request->validate([
            'solicitud_id' => ['required', 'integer', 'min:1'],
        ]);

        $solicitudId = (int) $datos['solicitud_id'];

        // Eloquent::find() usa PDO parameterizado; no es posible inyección SQL aquí.
        $denuncia = Denuncia::find($solicitudId);

        // Verificar que la solicitud existe
        if (!$denuncia) {
            return response()->json([
                'status'  => false,
                'mensaje' => 'No existe ese folio de solicitud.',
                'url'     => '',
            ]);
        }

        // Construir la URL pública usando el UUID único de la denuncia
        $url = url('/' . $denuncia->uuid);

        return response()->json([
            'status'  => true,
            'mensaje' => 'URL generada correctamente.',
            'url'     => $url,
        ]);
    }
}
