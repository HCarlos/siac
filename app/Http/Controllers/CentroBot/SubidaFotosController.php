<?php
/**
 * SubidaFotosController.php
 *
 * Controlador público (sin autenticación) para que el ciudadano suba fotos
 * de una solicitud de servicio municipal mediante una URL única basada en UUID.
 *
 * El guardado de imágenes replica exactamente el patrón de
 * StorageDenunciaAmbitoController (saveFileAmbito / attaches).
 *
 * Seguridad de subida (4 capas):
 *   1. Laravel Validation — image + mimes:jpg,jpeg,png,gif,webp + max:10240
 *   2. finfo magic bytes  — verifica la firma binaria real del archivo
 *   3. Doble extensión    — bloquea nombres como "shell.php.jpg"
 *   4. Escaneo de cabecera — detecta código PHP/script embebido en los primeros 2 KB
 *
 * Rutas:
 *   GET  /{uuid}             → show()  — página con detalles y galería
 *   POST /fotos/subir/{uuid} → store() — recibe y guarda UNA foto por llamada
 */

namespace App\Http\Controllers\CentroBot;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Denuncias\Denuncia;
use App\Models\Denuncias\Imagene;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SubidaFotosController extends Controller
{
    /** Disco de almacenamiento de imágenes de denuncias */
    protected string $disk = 'denuncia';

    /** Helper de imágenes y utilidades del sistema */
    protected FuncionesController $F;

    /**
     * Tipos MIME permitidos para subida de imágenes.
     * SVG excluido intencionalmente: puede contener XSS embebido.
     */
    protected array $mimesPermitidos = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    /**
     * Extensiones peligrosas que no deben aparecer en ninguna parte
     * del nombre original del archivo (previene ataques de doble extensión).
     */
    protected array $extensionesPeligrosas = [
        'php', 'php3', 'php4', 'php5', 'php7', 'phtml', 'phar',
        'exe', 'sh', 'bash', 'cgi', 'pl', 'py', 'rb',
        'asp', 'aspx', 'jsp', 'cfm',
        'js', 'html', 'htm', 'svg', 'xml',
    ];

    /**
     * Patrones de código malicioso a buscar en los primeros 2 KB del archivo.
     * Un archivo de imagen legítimo nunca contiene estas cadenas.
     */
    protected array $patronesMaliciosos = [
        '<?php', '<?=', '<%', '<script', 'eval(', 'exec(',
        'system(', 'passthru(', 'shell_exec(', 'base64_decode(',
    ];

    public function __construct()
    {
        $this->F = new FuncionesController();
    }

    // =========================================================================
    // SHOW — Página pública de subida de fotos
    // =========================================================================

    /**
     * Muestra la página pública para subir fotos de una solicitud.
     *
     * @param  string  $uuid  UUID único de la denuncia
     * @return \Illuminate\View\View
     */
    public function show(string $uuid)
    {
        $denuncia = Denuncia::where('uuid', $uuid)->first();

        if (!$denuncia) {
            abort(404, 'No se encontró la solicitud solicitada.');
        }

        $denuncia->load(['servicio', 'imagenes']);

        $urlSubir = route('subida_fotos.store', ['uuid' => $uuid]);

        return view('subida_fotos', compact('denuncia', 'urlSubir', 'uuid'));
    }

    // =========================================================================
    // STORE — Guarda una foto enviada por el ciudadano
    // =========================================================================

    /**
     * Recibe y guarda una foto enviada por el ciudadano.
     *
     * El frontend llama a este endpoint una vez por cada imagen seleccionada.
     * Replica el flujo de StorageDenunciaAmbitoController::subirArchivoDenunciaAmbito().
     *
     * Validación en 4 capas:
     *   1. Laravel Validation (MIME + tamaño + getimagesize)
     *   2. finfo magic bytes (firma binaria real)
     *   3. Doble extensión en nombre original
     *   4. Escaneo de código malicioso en cabecera del archivo
     *
     * Parámetros POST:
     *   - foto          (file, requerido)   imagen a subir
     *   - observaciones (string, opcional)  descripción de la foto
     *
     * @param  Request  $request
     * @param  string   $uuid
     * @return JsonResponse
     */
    public function store(Request $request, string $uuid): JsonResponse
    {
        $denuncia = Denuncia::where('uuid', $uuid)->first();

        if (!$denuncia) {
            return response()->json([
                'status'  => false,
                'mensaje' => 'No se encontró la solicitud indicada.',
            ], 404);
        }

        // ── Capa 1: validación de Laravel ────────────────────────────────────
        // - image:  verifica vía getimagesize() que el contenido sea imagen real
        // - mimes:  restringe a tipos seguros, excluye SVG (puede contener XSS)
        // - max:    limita peso a 10 MB
        $request->validate([
            'foto'          => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:10240'],
            'observaciones' => ['nullable', 'string', 'max:500'],
            // momento: solo los dos valores permitidos por el modelo Imagene
            'momento'       => ['nullable', 'string', 'in:ANTES,DESPUÉS'],
        ], [
            'foto.required'  => 'Debe seleccionar una imagen.',
            'foto.image'     => 'El archivo debe ser una imagen válida.',
            'foto.mimes'     => 'Solo se permiten imágenes JPG, PNG, GIF o WEBP.',
            'foto.max'       => 'La imagen no puede superar los 10 MB.',
            'momento.in'     => 'El campo momento debe ser ANTES o DESPUÉS.',
        ]);

        $file = $request->file('foto');

        // ── Capa 2: verificación de magic bytes con finfo ─────────────────────
        // Detecta el tipo real del archivo por su firma binaria,
        // independiente de la extensión declarada o del encabezado HTTP.
        $finfo    = new \finfo(FILEINFO_MIME_TYPE);
        $mimeReal = $finfo->file($file->getRealPath());

        if (!in_array($mimeReal, $this->mimesPermitidos, true)) {
            return response()->json([
                'status'  => false,
                'mensaje' => 'El archivo no es una imagen válida (verificación de firma binaria fallida).',
            ], 422);
        }

        // ── Capa 3: chequeo de doble extensión en nombre original ─────────────
        // Previene ataques tipo "shell.php.jpg" donde el servidor podría
        // interpretar la extensión interna en lugar de la externa.
        $nombreOriginal = strtolower($file->getClientOriginalName());
        $partes         = explode('.', $nombreOriginal);

        foreach ($partes as $parte) {
            if (in_array(trim($parte), $this->extensionesPeligrosas, true)) {
                return response()->json([
                    'status'  => false,
                    'mensaje' => 'El nombre del archivo contiene una extensión no permitida.',
                ], 422);
            }
        }

        // ── Capa 4: escaneo de código malicioso en cabecera del archivo ───────
        // Lee los primeros 2 KB y busca patrones de código PHP/script.
        // Un archivo de imagen legítimo nunca contiene estas cadenas al inicio.
        $cabecera = file_get_contents($file->getRealPath(), false, null, 0, 2048);

        foreach ($this->patronesMaliciosos as $patron) {
            if (stripos($cabecera, $patron) !== false) {
                return response()->json([
                    'status'  => false,
                    'mensaje' => 'El archivo contiene contenido no permitido.',
                ], 422);
            }
        }

        try {
            $observaciones = trim($request->input('observaciones', ''));

            if ($observaciones === '') {
                $observaciones = 'Foto enviada por el ciudadano desde la URL pública.';
            }

            // Obtener coordenadas reales del lugar reportado en la solicitud
            $latitud  = (float) ($denuncia->latitud  ?? 0);
            $longitud = (float) ($denuncia->longitud ?? 0);

            // Momento: valor enviado desde el formulario; fallback a 'ANTES'
            $momento = strtoupper(trim($request->input('momento', 'ANTES')));
            if (!in_array($momento, ['ANTES', 'DESPUÉS'], true)) {
                $momento = 'ANTES';
            }

            // Paso 1: crear el registro Imagene con datos mínimos
            //         (igual que subirArchivoDenunciaAmbito)
            $img = Imagene::create([
                'fecha'        => Carbon::parse($denuncia->fecha_ingreso)->format('Y-m-d H:i:s'),
                'user__id'     => $denuncia->ciudadano_id,
                'denuncia__id' => $denuncia->id,
                'titulo'       => 'Enviada por el ciudadano',
                'descripcion'  => $observaciones,
                'momento'      => $momento,
                'latitud'      => $latitud,
                'longitud'     => $longitud,
            ]);

            // Paso 2: asociar imagen al usuario y a la denuncia (pivots)
            $this->attaches($img, $denuncia);

            // Paso 3: guardar archivo en disco y generar thumbnails
            $this->saveFileAmbito($img, $file, $denuncia);

            // Recargar para obtener los nombres de archivo ya actualizados
            $img->refresh();

            $pathPublico  = '/storage/denuncia/';
            $urlImagen    = config('atemun.public_url') . $pathPublico . $img->image;
            $urlThumbnail = config('atemun.public_url') . $pathPublico . $img->image_thumb;

            return response()->json([
                'status'        => true,
                'mensaje'       => '¡Foto subida correctamente!',
                'imagen_id'     => $img->id,
                'url_imagen'    => $urlImagen,
                'url_thumb'     => $urlThumbnail,
                'observaciones' => $img->descripcion,
                'momento'       => $img->momento,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'mensaje' => 'Ocurrió un error al guardar la imagen: ' . $e->getMessage(),
            ], 500);
        }
    }

    // =========================================================================
    // HELPERS — réplica fiel de StorageDenunciaAmbitoController
    // =========================================================================

    /**
     * Asocia la imagen al usuario propietario y a la denuncia mediante los
     * pivots imagene_user y denuncia_imagene.
     *
     * Replica StorageDenunciaAmbitoController::attaches().
     *
     * @param  Imagene   $item
     * @param  Denuncia  $denuncia
     * @return Imagene
     */
    protected function attaches(Imagene $item, Denuncia $denuncia): Imagene
    {
        // Asociar al usuario propietario de la solicitud (tabla imagene_user)
        $item->users()->attach($item->user__id);

        // Asociar a la denuncia (tabla denuncia_imagene)
        $den = Denuncia::find($denuncia->id);
        $den->imagenes()->attach($item);

        return $item;
    }

    /**
     * Desasocia la imagen del usuario y de la denuncia.
     *
     * Replica StorageDenunciaAmbitoController::detaches().
     *
     * @param  Imagene   $item
     * @param  Denuncia  $denuncia
     * @return Imagene
     */
    protected function detaches(Imagene $item, Denuncia $denuncia): Imagene
    {
        $item->users()->detach($item->user__id);

        $den = Denuncia::find($denuncia->id);
        $den->imagenes()->detach($item->id);

        return $item;
    }

    /**
     * Guarda el archivo en disco y genera thumbnail (128×128) y versión
     * media (300×300). Actualiza el registro Imagene con los nombres definitivos.
     *
     * Replica StorageDenunciaAmbitoController::saveFileAmbito().
     *
     * @param  Imagene                          $item
     * @param  \Illuminate\Http\UploadedFile    $file
     * @param  Denuncia                         $denuncia
     * @return bool
     */
    protected function saveFileAmbito(Imagene $item, $file, Denuncia $denuncia): bool
    {
        if (!$file) {
            return false;
        }

        $ext  = $file->extension();
        $name = sha1(date('YmdHis') . time()) . '-' . $item->user__id . '-' . $denuncia->id;

        $fileName  = $name . '.' . $ext;         // imagen original
        $fileName2 = '_' . $name . '.png';        // versión media 300×300
        $thumbnail = '_thumb_' . $name . '.png';  // thumbnail 128×128

        // Actualizar el registro antes de guardar en disco
        $item->update([
            'root'        => config('atemun.public_url'),
            'image'       => $fileName,
            'image_thumb' => $thumbnail,
        ]);

        // Guardar el archivo original
        Storage::disk($this->disk)->put($fileName, File::get($file));

        // Generar thumbnail y versión media solo si no es documento
        if (!in_array($ext, config('atemun.document_type_extension'), true)) {
            $this->F->fitImage($file, $thumbnail,  128, 128, true, $this->disk, 'DENUNCIA_ROOT');
            $this->F->fitImage($file, $fileName2,  300, 300, true, $this->disk, 'DENUNCIA_ROOT');
        }

        return true;
    }
}
