<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Subir Fotos · Solicitud #{{ $denuncia->id }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /*
         * ═══════════════════════════════════════════════════════════
         * PALETA OFICIAL SIAC
         *   --carmesi  : #96262C  — primario  (encabezados, énfasis)
         *   --dorado   : #987323  — secundario (detalles, acentos)
         *   --carbon   : #57595A  — neutro    (texto secundario)
         * ═══════════════════════════════════════════════════════════
         */
        :root {
            --carmesi     : #96262C;
            --carmesi-osc : #7a1e22;
            --carmesi-bg  : #fdf0f0;
            --carmesi-tint: #f5d0d2;

            --dorado      : #987323;
            --dorado-osc  : #7a5c1c;
            --dorado-bg   : #fdf8ec;
            --dorado-tint : #f0e3b8;

            --carbon      : #57595A;
            --carbon-cl   : #8c8e8f;
            --carbon-bg   : #f4f4f4;

            --borde       : #e0dbd3;
            --fondo       : #f6f4f1;
        }

        body {
            background-color: var(--fondo);
            font-family: 'Segoe UI', sans-serif;
            color: #2c2c2c;
        }

        /* ── Franja de color superior ────────────────────────────── */
        .top-stripe {
            height: 4px;
            background: linear-gradient(90deg, var(--carmesi) 0%, var(--dorado) 60%, var(--carbon) 100%);
        }

        /* ── Encabezado ──────────────────────────────────────────── */
        .siac-header {
            background: var(--carmesi);
            color: #fff;
            padding: 1.25rem 0;
            position: relative;
            overflow: hidden;
        }
        .siac-header::after {
            content: '';
            position: absolute; right: -30px; top: -30px;
            width: 160px; height: 160px; border-radius: 50%;
            background: rgba(152,115,35,.15);
            pointer-events: none;
        }
        .siac-header .logo-text { font-size: 1.5rem; font-weight: 700; letter-spacing: 1px; }
        .siac-header .logo-sub  { font-size: 0.78rem; opacity: 0.85; }
        .siac-header .escudo {
            width: 52px; height: 52px; border-radius: 50%;
            background: rgba(255,255,255,.15);
            border: 2px solid rgba(255,255,255,.3);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .siac-header .escudo i { font-size: 1.6rem; color: #fff; }

        /* ── Folio badge ─────────────────────────────────────────── */
        .folio-badge {
            background: var(--carmesi);
            color: #fff; font-size: 1.05rem; font-weight: 700;
            padding: 0.35rem 1rem; border-radius: 2rem;
            display: inline-block;
            box-shadow: 0 2px 6px rgba(150,38,44,.35);
        }

        /* ── Tarjeta de detalles ─────────────────────────────────── */
        .card-detalle { border-left: 5px solid var(--dorado); border-radius: .5rem; }
        .card-detalle .card-title { color: var(--carmesi-osc); }

        /* ── Zona de carga ───────────────────────────────────────── */
        .drop-zone {
            border: 2.5px dashed var(--dorado);
            border-radius: 0.75rem;
            background: var(--dorado-bg);
            padding: 2rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s;
        }
        .drop-zone:hover,
        .drop-zone.drag-over {
            background: var(--dorado-tint);
            border-color: var(--dorado-osc);
        }
        .drop-zone i { font-size: 3rem; color: var(--dorado); }
        .drop-zone p.fw-semibold { color: var(--carmesi-osc); }

        /* ── Campo momento ───────────────────────────────────────── */
        .momento-group {
            display: flex; gap: .75rem; flex-wrap: wrap;
        }
        .momento-label {
            flex: 1; min-width: 120px;
            cursor: pointer;
        }
        .momento-label input[type="radio"] { display: none; }
        .momento-btn {
            display: flex; align-items: center; justify-content: center; gap: .4rem;
            padding: .55rem 1rem; border-radius: .45rem;
            border: 2px solid var(--borde);
            background: #fff; color: var(--carbon);
            font-weight: 600; font-size: .9rem;
            transition: all .15s;
            user-select: none;
        }
        .momento-label input[type="radio"]:checked + .momento-btn {
            border-color: var(--carmesi);
            background: var(--carmesi-bg);
            color: var(--carmesi);
        }
        .momento-label:hover .momento-btn {
            border-color: var(--dorado);
            background: var(--dorado-bg);
        }

        /* ── Lista de archivos en cola ───────────────────────────── */
        .archivo-item {
            background: #fff;
            border: 1px solid var(--borde);
            border-radius: 0.5rem;
            padding: 0.6rem 0.8rem;
            margin-bottom: 0.4rem;
            font-size: 0.88rem;
        }
        .archivo-item .progress      { height: 8px; }
        .archivo-item .estado-icon   { font-size: 1.1rem; }
        .progress-bar-carmesi        { background-color: var(--carmesi) !important; }
        .progress-bar-dorado         { background-color: var(--dorado)  !important; }

        /* ── Botón de subida ─────────────────────────────────────── */
        .btn-subir {
            background: var(--carmesi);
            border-color: var(--carmesi);
            color: #fff; font-weight: 600;
            transition: background .15s;
        }
        .btn-subir:hover:not(:disabled) {
            background: var(--carmesi-osc);
            border-color: var(--carmesi-osc);
            color: #fff;
        }
        .btn-subir:disabled { opacity: .55; }

        /* ── Galería ─────────────────────────────────────────────── */
        .galeria-img {
            width: 100%; height: 140px; object-fit: cover;
            border-radius: 0.4rem; cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 2px solid transparent;
        }
        .galeria-img:hover {
            transform: scale(1.04);
            border-color: var(--dorado);
            box-shadow: 0 3px 10px rgba(150,38,44,.2);
        }

        /* ── Badges de momento en galería ────────────────────────── */
        .badge-antes  { background: var(--dorado-bg);  color: var(--dorado-osc);  border: 1px solid var(--dorado-tint); font-size: .65rem; }
        .badge-despues{ background: var(--carmesi-bg); color: var(--carmesi);     border: 1px solid var(--carmesi-tint); font-size: .65rem; }

        /* ── Contador de fotos ───────────────────────────────────── */
        .badge-contador {
            background: var(--carbon);
            color: #fff; font-size: .78rem;
        }

        /* ── Títulos de sección ──────────────────────────────────── */
        .card-title-section { color: var(--carmesi); font-weight: 700; }

        /* ── Footer ──────────────────────────────────────────────── */
        footer {
            background: var(--carbon);
            color: rgba(255,255,255,.72);
            font-size: 0.82rem; padding: 0.9rem 0;
            border-top: 3px solid var(--dorado);
        }
    </style>
</head>
<body>

{{-- Franja de color superior --}}
<div class="top-stripe"></div>

{{-- ═══════════════════════════ ENCABEZADO ══════════════════════════ --}}
<header class="siac-header mb-4">
    <div class="container">
        <div class="d-flex align-items-center gap-3" style="position:relative;z-index:1;">
            <div class="escudo">
                <i class="bi bi-building-check"></i>
            </div>
            <div>
                <div class="logo-text">SISM</div>
                <div class="logo-sub">Sistema Integral de Servicios Municipales</div>
                <div class="logo-sub">Coordinación de Transformación Digital e Innovación</div>
                <div class="logo-sub">H. Ayuntamiento Constitucional de Centro</div>
            </div>
        </div>
    </div>
</header>

<main class="container pb-5">

    {{-- ═══════════════════ DETALLES DE LA SOLICITUD ═══════════════════ --}}
    <div class="card card-detalle shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <h5 class="card-title card-title-section mb-0">
                    <i class="bi bi-clipboard-check me-1"></i>
                    Detalles de la Solicitud
                </h5>
                <span class="folio-badge"># {{ $denuncia->id }}</span>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="small mb-1" style="color:var(--carbon-cl);">
                        <i class="bi bi-tools me-1"></i> Servicio solicitado
                    </div>
                    <div class="fw-semibold">{{ optional($denuncia->servicio)->servicio ?? 'Sin especificar' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="small mb-1" style="color:var(--carbon-cl);">
                        <i class="bi bi-calendar-event me-1"></i> Fecha de ingreso
                    </div>
                    <div class="fw-semibold">
                        @if($denuncia->fecha_ingreso)
                            {{ \Carbon\Carbon::parse($denuncia->fecha_ingreso)->format('d/m/Y') }}
                        @else —
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <div class="small mb-1" style="color:var(--carbon-cl);">
                        <i class="bi bi-geo-alt me-1"></i> Dirección
                    </div>
                    <div class="fw-semibold">
                        @php
                            $partes = array_filter([
                                $denuncia->calle,
                                $denuncia->num_ext ? 'No. ' . $denuncia->num_ext : null,
                                $denuncia->num_int ? 'Int. ' . $denuncia->num_int : null,
                                $denuncia->colonia,
                                $denuncia->ciudad,
                            ]);
                        @endphp
                        {{ implode(', ', $partes) ?: 'Sin dirección registrada' }}
                    </div>
                </div>

                @if($denuncia->descripcion)
                <div class="col-12">
                    <div class="small mb-1" style="color:var(--carbon-cl);">
                        <i class="bi bi-chat-text me-1"></i> Descripción
                    </div>
                    <div class="rounded p-2" style="font-size:.95rem;background:var(--fondo);border:1px solid var(--borde);">
                        {{ $denuncia->descripcion }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══════════════════════ FORMULARIO DE SUBIDA ═══════════════════════ --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title card-title-section mb-1">
                <i class="bi bi-camera-fill me-1"></i>
                Subir fotos de la solicitud
            </h5>
            <p class="small mb-4" style="color:var(--carbon-cl);">
                Puede seleccionar varias fotos a la vez. Formatos: JPG, PNG, GIF, WEBP. Máximo 10 MB por imagen.
            </p>

            {{-- Zona de carga (drag & drop o clic) --}}
            <div class="drop-zone mb-4" id="drop-zone">
                <i class="bi bi-cloud-upload"></i>
                <p class="mt-2 mb-0 fw-semibold">Haga clic o arrastre las fotos aquí</p>
                <p class="small mb-0" style="color:var(--carbon-cl);">Puede seleccionar múltiples imágenes</p>
            </div>

            {{-- Input múltiple oculto --}}
            <input type="file"
                   id="inputFotos"
                   accept="image/*"
                   multiple
                   class="d-none"
                   onchange="alSeleccionarArchivos(this.files)">

            {{-- ── Momento: ANTES / DESPUÉS ──────────────────────── --}}
            <div class="mb-3">
                <label class="form-label small fw-semibold mb-2" style="color:var(--carbon);">
                    <i class="bi bi-clock-history me-1"></i>
                    Momento de la fotografía
                </label>
                <div class="momento-group">
                    {{-- ANTES — predeterminado --}}
                    <label class="momento-label">
                        <input type="radio" name="momento" id="momento-antes" value="ANTES" checked>
                        <span class="momento-btn">
                            <i class="bi bi-camera"></i> ANTES
                        </span>
                    </label>
                    {{-- DESPUÉS --}}
                    <label class="momento-label">
                        <input type="radio" name="momento" id="momento-despues" value="DESPUÉS">
                        <span class="momento-btn">
                            <i class="bi bi-camera-fill"></i> DESPUÉS
                        </span>
                    </label>
                </div>
            </div>

            {{-- Observaciones globales (se aplican a todas las fotos del lote) --}}
            <div class="mb-3">
                <label for="observaciones" class="form-label small fw-semibold" style="color:var(--carbon);">
                    <i class="bi bi-pencil me-1"></i>
                    Observaciones <span style="font-weight:400;color:var(--carbon-cl);">(opcional — se aplica a todas las fotos)</span>
                </label>
                <textarea id="observaciones"
                          class="form-control"
                          rows="2"
                          maxlength="500"
                          style="border-color:var(--borde);"
                          placeholder="Describa brevemente lo que muestran las fotos..."></textarea>
            </div>

            {{-- Lista de archivos seleccionados con progreso individual --}}
            <div id="lista-archivos" class="mb-3"></div>

            {{-- Botón de subida --}}
            <button class="btn btn-subir w-100"
                    id="btn-subir"
                    onclick="subirTodas()"
                    disabled>
                <i class="bi bi-upload me-1"></i>
                Subir <span id="btn-contador"></span>
            </button>

            {{-- Alerta de resultado global --}}
            <div id="alerta-resultado" class="mt-3 d-none"></div>
        </div>
    </div>

    {{-- ══════════════════════════ GALERÍA ══════════════════════════════ --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title card-title-section mb-3">
                <i class="bi bi-images me-1"></i>
                Fotos ya subidas
                <span class="badge badge-contador ms-1" id="contador-fotos">
                    {{ $denuncia->imagenes->count() }}
                </span>
            </h5>

            <div class="row g-2" id="galeria-fotos">
                @forelse($denuncia->imagenes as $imagen)
                    @php
                        $urlImg   = config('atemun.public_url') . '/storage/denuncia/' . $imagen->image;
                        $urlThumb = config('atemun.public_url') . '/storage/denuncia/' . $imagen->image_thumb;
                        $esDespues = strtoupper($imagen->momento ?? '') === 'DESPUÉS';
                    @endphp
                    <div class="col-6 col-sm-4 col-md-3">
                        <a href="{{ $urlImg }}" target="_blank" title="{{ $imagen->descripcion }}">
                            <img src="{{ $urlThumb }}"
                                 alt="{{ $imagen->descripcion }}"
                                 class="galeria-img shadow-sm"
                                 onerror="this.src='{{ $urlImg }}'">
                        </a>
                        {{-- Badge de momento --}}
                        <div class="mt-1">
                            <span class="badge {{ $esDespues ? 'badge-despues' : 'badge-antes' }}">
                                {{ strtoupper($imagen->momento ?? 'ANTES') }}
                            </span>
                        </div>
                        @if($imagen->descripcion)
                            <div style="font-size:.75rem;color:var(--carbon-cl);margin-top:2px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;"
                                 title="{{ $imagen->descripcion }}">
                                {{ $imagen->descripcion }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-12 text-center py-4" id="sin-fotos-msg" style="color:var(--carbon-cl);">
                        <i class="bi bi-image" style="font-size:2.5rem;opacity:.35;"></i>
                        <p class="mt-2 mb-0">Aún no se han subido fotos para esta solicitud.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</main>

<footer class="text-center mt-4">
    <div class="container">
        SIAC — Sistema Integral de Atención Ciudadana &amp; Servicios Municipales ·
        H. Ayuntamiento de Villahermosa · {{ date('Y') }}
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const URL_SUBIR  = "{{ $urlSubir }}";
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Cola de archivos seleccionados: [{ file, id }]
    let cola  = [];
    let idSeq = 0;

    // ── Helpers de momento ───────────────────────────────────────────────────

    /**
     * Devuelve el valor seleccionado del campo momento (ANTES / DESPUÉS).
     */
    function getMomento() {
        const sel = document.querySelector('input[name="momento"]:checked');
        return sel ? sel.value : 'ANTES';
    }

    // ── Drag & Drop ──────────────────────────────────────────────────────────
    // Se registran con addEventListener para evitar conflicto con las propiedades
    // nativas window.ondragover / window.ondragleave / window.ondrop del DOM.

    (function () {
        const zona = document.getElementById('drop-zone');

        // Clic en la zona abre el selector de archivos
        zona.addEventListener('click', function () {
            document.getElementById('inputFotos').click();
        });

        // Prevenir comportamiento por defecto del navegador al arrastrar
        zona.addEventListener('dragover', function (e) {
            e.preventDefault();
            zona.classList.add('drag-over');
        });

        zona.addEventListener('dragleave', function (e) {
            // Solo quitar la clase si el cursor sale realmente de la zona
            if (!zona.contains(e.relatedTarget)) {
                zona.classList.remove('drag-over');
            }
        });

        zona.addEventListener('drop', function (e) {
            e.preventDefault();
            zona.classList.remove('drag-over');
            alSeleccionarArchivos(e.dataTransfer.files);
        });
    }());

    // ── Selección de archivos ────────────────────────────────────────────────

    /**
     * Procesa los archivos seleccionados (input o drag-drop).
     * Valida tipo imagen y tamaño en el cliente antes de agregar a la cola.
     */
    function alSeleccionarArchivos(files) {
        const lista = document.getElementById('lista-archivos');

        Array.from(files).forEach(function(file) {
            // Validación: tipo imagen
            if (!file.type.startsWith('image/')) {
                mostrarAlerta('advertencia',
                    '<i class="bi bi-exclamation-triangle-fill me-1"></i> "' +
                    escHtml(file.name) + '" no es una imagen válida y fue omitida.');
                return;
            }
            // Validación: tamaño (10 MB)
            if (file.size > 10 * 1024 * 1024) {
                mostrarAlerta('advertencia',
                    '<i class="bi bi-exclamation-triangle-fill me-1"></i> "' +
                    escHtml(file.name) + '" supera los 10 MB y fue omitida.');
                return;
            }

            const id = 'archivo-' + (++idSeq);
            cola.push({ file: file, id: id });

            // Fila de progreso para este archivo
            const div = document.createElement('div');
            div.className = 'archivo-item';
            div.id = id;
            div.innerHTML =
                '<div class="d-flex align-items-center justify-content-between mb-1">' +
                    '<span class="text-truncate me-2" style="max-width:70%;">' + escHtml(file.name) + '</span>' +
                    '<span class="estado-icon" id="' + id + '-icono"><i class="bi bi-hourglass" style="color:var(--carbon-cl);"></i></span>' +
                '</div>' +
                '<div class="progress">' +
                    '<div id="' + id + '-barra" class="progress-bar progress-bar-carmesi progress-bar-striped" role="progressbar" style="width:0%"></div>' +
                '</div>' +
                '<div id="' + id + '-msg" class="mt-1" style="font-size:.78rem;color:var(--carbon-cl);"></div>';
            lista.appendChild(div);
        });

        actualizarBoton();
        // Limpiar input para permitir seleccionar los mismos archivos de nuevo
        document.getElementById('inputFotos').value = '';
    }

    // ── Subida ───────────────────────────────────────────────────────────────

    /**
     * Sube todos los archivos de la cola de forma secuencial.
     * Captura el valor de momento y observaciones una vez para todo el lote.
     */
    async function subirTodas() {
        if (cola.length === 0) return;

        const btn          = document.getElementById('btn-subir');
        const observaciones = document.getElementById('observaciones').value;
        const momento       = getMomento();

        btn.setAttribute('disabled', true);
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Subiendo...';
        ocultarAlerta();

        let exitosas = 0;
        let fallidas = 0;

        for (const entrada of cola) {
            const ok = await subirArchivo(entrada.file, entrada.id, observaciones, momento);
            ok ? exitosas++ : fallidas++;
        }

        cola = [];
        actualizarBoton();

        if (fallidas === 0) {
            mostrarAlerta('exito',
                '<i class="bi bi-check-circle-fill me-1"></i> ' +
                exitosas + ' foto(s) subida(s) correctamente.');
            document.getElementById('observaciones').value = '';
            setTimeout(function() {
                document.getElementById('lista-archivos').innerHTML = '';
                ocultarAlerta();
            }, 4000);
        } else {
            mostrarAlerta('advertencia',
                '<i class="bi bi-exclamation-triangle-fill me-1"></i> ' +
                exitosas + ' subida(s) correctamente, ' + fallidas + ' con error.');
        }

        btn.removeAttribute('disabled');
        btn.innerHTML = '<i class="bi bi-upload me-1"></i> Subir <span id="btn-contador"></span>';
        actualizarBoton();
    }

    /**
     * Sube un único archivo mediante XHR y actualiza su barra de progreso.
     * Incluye momento y observaciones en el FormData.
     * Retorna true si tuvo éxito, false si falló.
     *
     * @param {File}   file
     * @param {string} id            — ID del elemento en la lista
     * @param {string} observaciones — texto descriptivo
     * @param {string} momento       — 'ANTES' | 'DESPUÉS'
     */
    function subirArchivo(file, id, observaciones, momento) {
        return new Promise(function(resolve) {
            const formData = new FormData();
            formData.append('foto',          file);
            formData.append('observaciones', observaciones);
            formData.append('momento',       momento);
            formData.append('_token',        CSRF_TOKEN);

            const barra = document.getElementById(id + '-barra');
            const icono = document.getElementById(id + '-icono');
            const msg   = document.getElementById(id + '-msg');

            const xhr = new XMLHttpRequest();

            // Progreso de carga
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    barra.style.width = Math.round((e.loaded / e.total) * 100) + '%';
                }
            });

            // Respuesta del servidor
            xhr.addEventListener('load', function() {
                try {
                    const resp = JSON.parse(xhr.responseText);

                    if (resp.status === true) {
                        barra.style.width = '100%';
                        barra.classList.remove('progress-bar-carmesi', 'progress-bar-striped');
                        barra.classList.add('progress-bar-dorado');
                        icono.innerHTML = '<i class="bi bi-check-circle-fill" style="color:var(--dorado);"></i>';
                        msg.textContent = '';

                        agregarImagenAGaleria(resp.url_thumb, resp.url_imagen, resp.observaciones, resp.momento);
                        resolve(true);
                    } else {
                        marcarError(barra, icono, msg, resp.mensaje);
                        resolve(false);
                    }
                } catch (err) {
                    marcarError(barra, icono, msg, 'Error al procesar la respuesta del servidor.');
                    resolve(false);
                }
            });

            xhr.addEventListener('error', function() {
                marcarError(barra, icono, msg, 'Error de conexión.');
                resolve(false);
            });

            xhr.open('POST', URL_SUBIR);
            xhr.setRequestHeader('X-CSRF-TOKEN', CSRF_TOKEN);
            xhr.send(formData);
        });
    }

    // ── Galería ──────────────────────────────────────────────────────────────

    /**
     * Inserta la imagen recién subida al inicio de la galería.
     * Muestra el badge de momento (ANTES / DESPUÉS).
     */
    function agregarImagenAGaleria(urlThumb, urlImagen, observaciones, momento) {
        const sinFotos = document.getElementById('sin-fotos-msg');
        if (sinFotos) sinFotos.remove();

        const galeria  = document.getElementById('galeria-fotos');
        const contador = document.getElementById('contador-fotos');
        contador.textContent = (parseInt(contador.textContent, 10) || 0) + 1;

        const esDespues    = (momento || '').toUpperCase() === 'DESPUÉS';
        const badgeClass   = esDespues ? 'badge-despues' : 'badge-antes';
        const momentoLabel = esDespues ? 'DESPUÉS' : 'ANTES';

        const desc = observaciones
            ? '<div style="font-size:.75rem;color:var(--carbon-cl);margin-top:2px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;" title="' + escHtml(observaciones) + '">' + escHtml(observaciones) + '</div>'
            : '';

        const col = document.createElement('div');
        col.className = 'col-6 col-sm-4 col-md-3';
        col.innerHTML =
            '<a href="' + urlImagen + '" target="_blank" title="' + escHtml(observaciones || 'Foto') + '">' +
                '<img src="' + urlThumb + '" alt="' + escHtml(observaciones || 'Foto') + '" ' +
                     'class="galeria-img shadow-sm" onerror="this.src=\'' + urlImagen + '\'">' +
            '</a>' +
            '<div class="mt-1">' +
                '<span class="badge ' + badgeClass + '">' + momentoLabel + '</span>' +
            '</div>' +
            desc;

        galeria.insertBefore(col, galeria.firstChild);
    }

    // ── Utilidades ───────────────────────────────────────────────────────────

    function actualizarBoton() {
        const btn      = document.getElementById('btn-subir');
        const contador = document.getElementById('btn-contador');
        if (cola.length > 0) {
            btn.removeAttribute('disabled');
            contador.textContent = cola.length + ' foto' + (cola.length > 1 ? 's' : '');
        } else {
            btn.setAttribute('disabled', true);
            if (contador) contador.textContent = '';
        }
    }

    function marcarError(barra, icono, msg, texto) {
        barra.style.width = '100%';
        barra.classList.remove('progress-bar-carmesi', 'progress-bar-striped');
        barra.style.backgroundColor = 'var(--carmesi)';
        icono.innerHTML = '<i class="bi bi-x-circle-fill" style="color:var(--carmesi);"></i>';
        msg.textContent  = texto;
        msg.style.color  = 'var(--carmesi)';
        msg.style.fontSize = '.78rem';
    }

    function mostrarAlerta(tipo, html) {
        const cont = document.getElementById('alerta-resultado');
        const estilos = {
            'exito':       'background:var(--dorado-bg);border:1px solid var(--dorado);color:var(--dorado-osc);',
            'advertencia': 'background:var(--carmesi-bg);border:1px solid var(--carmesi);color:var(--carmesi-osc);',
        };
        cont.setAttribute('style', (estilos[tipo] || '') + 'padding:.75rem 1rem;border-radius:.45rem;');
        cont.innerHTML = html;
        cont.classList.remove('d-none');
    }

    function ocultarAlerta() {
        const cont = document.getElementById('alerta-resultado');
        cont.classList.add('d-none');
        cont.innerHTML = '';
    }

    function escHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
</script>

</body>
</html>
