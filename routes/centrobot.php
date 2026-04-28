<?php
/**
 * centrobot.php
 *
 * Rutas para el CentroBot y la subida pública de fotos por el ciudadano.
 * Este archivo es incluido desde routes/web.php y hereda el middleware 'web'.
 *
 * Rutas registradas:
 *   GET  /centrobot/generar-url-fotos       → CentroBotController@generarUrlSubidaFotos
 *   GET  /{uuid}                            → SubidaFotosController@show
 *   POST /fotos/subir/{uuid}               → SubidaFotosController@store
 */

use Illuminate\Support\Facades\Route;

// ── CentroBot ─────────────────────────────────────────────────────────────────
// Genera una URL pública única (basada en UUID) para que el ciudadano suba fotos.
// Consumida por el bot de WhatsApp u otros canales externos.
// Se usa GET porque es una consulta de lectura; no modifica estado.
Route::get('/centrobot/generar-url-fotos', 'CentroBot\CentroBotController@generarUrlSubidaFotos')
    ->name('centrobot.generar_url_fotos');

// ── Subida pública de fotos ───────────────────────────────────────────────────
// Página pública para el ciudadano (acceso por URL única basada en UUID).
// La ruta POST se registra ANTES del GET para evitar ambigüedad con /{uuid}.

Route::post('/fotos/subir/{uuid}', 'CentroBot\SubidaFotosController@store')
    ->name('subida_fotos.store')
    ->where('uuid', '[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}');

Route::get('/{uuid}', 'CentroBot\SubidaFotosController@show')
    ->name('subida_fotos.show')
    ->where('uuid', '[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}');
