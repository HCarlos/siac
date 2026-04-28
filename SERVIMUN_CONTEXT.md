# SERVIMUN / SIAC — Contexto del Proyecto

> Archivo mantenido por Claude. Actualizar al finalizar cada tarea significativa.
> Última actualización: 2026-03-18

---

## Stack Tecnológico

| Herramienta | Versión / Detalle |
|---|---|
| PHP | 7.4 |
| Laravel | 7.x |
| Base de datos | PostgreSQL (`dbatemun`) |
| Cache / Sesiones | Redis (phpredis) |
| Broadcasting | Redis + Laravel Echo + Socket.io |
| Autenticación API | Laravel Sanctum |
| Colas | Driver `sync` |
| Frontend | Bootstrap 4, jQuery 3.6, DataTables, Select2, Chart.js, ApexCharts, Leaflet 1.9.4 |
| PDF | TCPDF |
| Excel | Manipulación directa de XML (ZIP) |

---

## Entornos

| Entorno | URL / Ruta | Sistema |
|---------|-----------|---------|
| Desarrollo | `http://192.168.90.10` — `/var/www/servimun` | Vagrant / Ubuntu |
| Producción | https://siac.villahermosa.gob.mx | AlmaLinux / Apache |

---

## Convenciones de Commits

- Formato: `SIAC - C44<letra><número> | L7.30.7 Production`
- Ejemplo reciente: `SIAC - C44ñ1 | L7.30.7 Production`

---

## Archivos Clave

| Archivo | Descripción |
|---|---|
| `CLAUDE.md` | Reglas del proyecto para Claude |
| `SERVIMUN_CONTEXT.md` | Este archivo — contexto y avances |
| `routes/web.php` | ~401 rutas web (todas las del sistema) |
| `routes/api.php` | Rutas API v1 y v1b |
| `app/Console/Kernel.php` | Scheduler de comandos Artisan |
| `app/Providers/EventServiceProvider.php` | Registro de eventos/listeners |
| `config/atemun.php` | Config propietaria del sistema (150+ claves) |
| `app/helpers.php` | Helper global: `streamCsvResponse()` |

---

## Variables `.env` Clave

```
APP_NAME="Sistema Integral de Atención Ciudadana y Servicios Municipales"
APP_NAME_SHORT="SIAC"
DB_CONNECTION=pgsql  /  DB_DATABASE=dbatemun
BROADCAST_DRIVER=redis  /  QUEUE_CONNECTION=sync
EMPRESA_ID=1  /  SAS_ID=12
ESTATUS_DEFAULT_SERVICIOS_MUNICIPALES=16
ESTATUS_DEFAULT_SERVICIOS_VIEJITOS=8
MODIFICAR_FECHA_INGRESO=NO
DIAS_MAS_FECHA_INGRESO=1 / DIAS_MAS_FECHA_EJECUCION=3 / DIAS_MAS_FECHA_LIMITE=5
GOOGLE_MAPS_KEY=AIzaSyBUl6Jk2_5yVYdnwidOuU9c8_ZBk7gGnfo
PUBLIC_URL=...  (URL pública para imágenes y storage)
LARAVEL_ECHO_PORT=...  (puerto de Socket.io)
```

---

## Jerarquía Organizacional

```
dependencias → areas → subareas → servicios
```

Ámbitos del sistema (`ambito_dependencia`):
- `1` = Apoyos Sociales (AS)
- `2` = Servicios Municipales (SM) — nuevo
- `99` = SM legado / todos

---

## Roles de Usuario

| Rol | Descripción |
|-----|-------------|
| `Administrator` / `SysOp` | Acceso total |
| `USER_OPERATOR_ADMIN` | Operador con permisos admin |
| `USER_OPERATOR_SIAC` | Operador de campo |
| `ENLACE` | Enlace de dependencia — ve solo sus dependencias |
| `DELEGADOS` / `DELEGADO` | Delegado territorial |
| `COORDINACION_DE_DELEGADOS` | Coordinador de delegados |
| `USER_ARCHIVO_CAP` / `USER_ARCHIVO_ADMIN` | Gestión de archivo |
| `CIUDADANO` | Ciudadano registrado |

Regla importante: si el usuario es `ENLACE` y no especifica `dependencia_id`, el sistema filtra automáticamente por sus dependencias asignadas (`user->dependencias()`).

---

## Base de Datos: `dbatemun`

### Estadísticas (mar-2026)
- `denuncias`: ~145,710 registros
- `users`: ~520,311 registros
- `servicios`: 401 registros

### Catálogo `estatus`
| id | nombre | abreviatura | resuelto | ambito |
|----|--------|-------------|----------|--------|
| 1 | EN PROCESO | ENPROC | 0 | 99 |
| 6 | RESUELTO | RES | 1 | 99 |
| 8 | RECIBIDO | REC | 0 | 99 |
| 16 | RECIBIDA | RDAS | 0 | 2 |
| 17 | ATENDIDA | ATN | 1 | 2 |
| 18 | OBSERVADO | OBS | 0 | 2 |
| 19 | EN PROCESO/PROG | PROPR | 0 | 2 |
| 20 | RECHAZADA | RECH | 1 | 2 |

### Dependencias Clave
| id | abreviatura | ambito |
|----|-------------|--------|
| 1 | DOOTSM (Obras/SM) | 99 |
| 12 | SAS | 99 |
| 13 | SAPYE (Alumbrado) | 99 |
| 20 | ATC (Atención Ciudadana) | 1 |
| 46-50 | SM ambito=2 | 2 |
| 51-55 | AS ambito=1 | 1 |

### Vistas Principales
```
_videnuncias          → incluye ambito_dependencia (heredada de dependencias)
_viddss               → historial DDSE resumido
_viddss_completa      → historial DDSE completo
_viddss_viejitas      → servicios "viejitos" (sistema anterior)
_vimov_sm_nov         → ue_id, fecha_ultimo_estatus, fecha_dias_ejecucion, fecha_dias_maximos_ejecucion
_vimov_filter_sm      → movimientos filtrados SM
_vimov_filter_sm_todas → movimientos SM agrupados (problema: ver sección Avances)
_vimov_sas_sm         → movimientos SAS/SM
_vimovimientos        → todos los movimientos
_viservicios          → catálogo de servicios
_viusers              → usuarios con datos extendidos
_viuserestatus        → usuarios con estatus
_viddsestatus_nov     → DDSE con estatus (nov en adelante)
_videpdenservestatus  → scope por dependencias del usuario
```

### Tablas por Dominio
- **Domicilio:** `paises → estados → municipios → ciudades → colonias → comunidades → ubicaciones`
- **Mobile:** `usermobile, denunciamobile, serviciomobile, imagemobile, respuestamobile`
- **Roles/Permisos (Spatie-like):** `roles, permissions, model_has_roles, model_has_permissions, role_has_permissions, role_user, permission_user, permission_role`
- **Pivotes DDSE:** `denuncia_dependencia_servicio_estatus` (tabla central del flujo de estatus)

---

## Modelos: Campos Clave y Advertencias

### `Denuncia`
**Tabla:** `denuncias`
- `$dates`: `fecha_ingreso`, `fecha_cerrado` → **Carbon**
- `fecha_ultimo_estatus` → **NO** está en `$dates` → llega como **string** desde DB → wrappear con `new DateTime()`
- `ue_id` → entero (ID del último estatus)
- `due_id` → entero (ID de la última dependencia)
- `sue_id` → entero (ID del último servicio)
- `ultimo_estatus()` → relación `hasOne(Estatu, 'id', 'ue_id')` — devuelve objeto, **no usar como ID**
- `ambito`: 0=SM_legado, 1=normal, 2=SM_nuevo
- `dias_atendida`, `dias_rechazada`, `dias_observada` → enteros calculados
- Traits: `DenunciaTrait`, `SoftDeletes`
- Scopes: `Search()`, `FilterBy()`, `AmbitoFilterBy()`, `GetDenunciasItemCustomFilter()`, etc.
- Método: `semaforo_ultimo_estatus()` → llama a `ActualizaEstadisticasARO::semaforo_ultimo_estatus_off()`
- **Relaciones principales:**
  - `dependencias()` → belongsToMany con pivot: `fecha_movimiento, observaciones, favorable, fue_leida, creadopor_id`
  - `ultimo_estatu_denuncia_dependencia_servicio()` → hasMany(Denuncia_Dependencia_Servicio)
  - `imagenes()`, `respuestas()`, `firmas()`, `operadores()` → todos N:M

### `Denuncia_Dependencia_Servicio` (DDSE)
**Tabla:** `denuncia_dependencia_servicio_estatus` — **tabla central del historial**
- `$dates`: `fecha_movimiento` → **Carbon**
- `$fillable`: `denuncia_id, dependencia_id, servicio_id, estatu_id, fecha_movimiento, observaciones, favorable, fue_leida, creadopor_id`
- Relaciones: `denuncia()`, `estatu()`, `dependencia()`, `servicio()`, `creadopor()`, `imagenes()`

### `User`
**Tabla:** `users`
- Traits: `HasApiTokens`, `SoftDeletes`, `HasRoles`, `HasPermissions`, `UserImport`, `UserAttributes`
- Appends: `role_id_str_array`, `role_id_array`, `dependencia_id_array`, `str_genero`, `full_name`
- Relaciones clave: `dependencias()`, `operadores()`, `supervisores()`, `MobileDevices()`, `roles()`, `permisos()`
- `operadores()` → belongsToMany(User, 'operador_supervisor', 'supervisor_id', 'operador_id') wherePivotNull('deleted_at')
- `supervisores()` → belongsToMany(User, 'operador_supervisor', 'operador_id', 'supervisor_id') wherePivotNull('deleted_at')
- Método: `getHomeAttribute()` → retorna ruta home según rol
- Método: `getUsernameNext($Abreviatura)` → genera username auto: "ABREV + ID_PADDED_6"

### `Servicio`
**Tabla:** `servicios`
- `promedio_dias_atendida`, `promedio_dias_rechazada`, `promedio_dias_observada` → recalculados por listener
- `dias_ejecucion`, `dias_maximos_ejecucion` → tiempos SLA del servicio
- `is_visible_mobile`, `nombre_mobile` → para app móvil
- Método estático: `getQueryServiciosFromDependencias($id, $efect)`

### `Imagene`
**Tabla:** `imagenes`
- `user__id`, `denuncia__id`, `parent__id` → campos con doble guión (legacy)
- Trait: `ImageneTrait` — accesores para paths web/thumb
- `momento` → "ANTES" / "DESPUÉS"
- `titulo`, `descripcion` → metadatos de la imagen

### Modelos de Vista (solo lectura)
`_viDDSs`, `_viDDSS_Viejitas`, `_viMovimientos`, `_viServicios`, `_viMovSM`, `_viMovSMTodas`, `_viDepDenServEstatus`
- No tienen escritura, mapean vistas PostgreSQL
- Duplican relaciones del modelo base para reporting

---

## Traits Clave

### `UserAttributes` (`app/Traits/User/`)
- `getFullNameAttribute()` → "APELLIDO_PAT APELLIDO_MAT NOMBRE"
- `getHomeAttribute()` → ruta home según rol
- `getDependenciaIdArrayAttribute()` → array de IDs de dependencias
- `isPermission($permissions)` → valida pipe-separated ("a|b|c")
- `getUsernameNext($Abreviatura)` → auto-generate username

### `DenunciaTrait` (`app/Traits/Denuncia/`)
- `getFolioDacAttribute()` → "DAC-{id_padded_6}-{YY}"
- `getUltimosEstatusAttribute()` → último estatus de DDSE (filtra por ENLACE)
- `getUltimaFechaEstatusAttribute()`, `getUltimaDependenciaAttribute()`, `getUltimoServicioAttribute()`

### `ImageneTrait` (`app/Traits/Denuncia/`)
- `getPathImageAttribute()`, `getPathImageThumbAttribute()`
- `getImage($tipoImage)` → resuelve path incluyendo documentos (.pdf, .doc, .xlsx)

---

## Clases de Negocio (`app/Classes/Denuncia/`)

### `ActualizaEstadisticasARO`
- `ActualizaEstadisticasARO($denuncia_id)` — recorre DDSE y despacha `DenunciaAtendidaEvent` para estatus 17/18/20
- `semaforo_ultimo_estatus_off($ue_id, $fecha_mayor, $fecha_menor): array`
  - Retorna: `{sem: 1|2|3, dias: int, status: verde|amarillo|rojo, status_i: green|yellow|red, class_color: ..., fecha_fin: ..., dias_vencidos: int}`
  - Estatus 17/20/21/22 → VERDE (resuelto)
  - Estatus 16/19 → calcula días; si aún hay tiempo → AMARILLO; si vencido → ROJO
  - Estatus 18 → AMARILLO siempre
  - **NUNCA escribe en DB** — solo retorna array

### `VistaDenunciaClass`
- `vistaDenuncia($denuncia_id): Denuncia`
  - Recorre DDSE de la denuncia
  - Actualiza en `denuncias`: `ue_id`, `due_id`, `sue_id`, `fecha_ultimo_estatus`, `estatus_general` (JSON), `favorable`
  - Sincroniza el estado actual de la denuncia con su historial DDSE

### `FiltersRules` / `FiltersRulesBySearch`
- `filterRulesDenuncia(Request $request): array` → normaliza filtros para consultas
- Si usuario es `ENLACE` sin `dependencia_id` → auto-filtra por sus dependencias

### `RepDelCiuInt1AClass`
- Servicios principales fijos: `[476, 508, 479, 483, 466, 503]`
- Orígenes fijos: `[29, 27, 25, 28, 3]`
- Métodos: `getRecibidasCiudadanos/Delegados/Internos()`, `getPendientesProm()`, `getAtendidasProm()`, etc.

### `DenunciaAmbitoMapClass`
- `printDenunciaAmbitoMap(Denuncia $den, TCPDF $pdf)` → inserta mapa Google Maps Static API en PDF
- `importPDFFile()` / `importImageFile()` → adjunta archivos en PDF

### `ParaReportesClass`
- `GetFiltroPorFechaYServicios($start, $end, $ServiciosPrincipales)` → IDs de denuncias en rango+servicios
- `GetFiltroPorFechaYServiciosViDenuncias($start, $end, $ServiciosPrincipales)` → de `_videnuncias` con ambito_dependencia=2

---

## Eventos y Listeners

### Todos implementan `ShouldBroadcast`

| Evento | Canal | Despachadado desde | Lógica clave |
|--------|-------|-------------------|--------------|
| `DenunciaAtendidaEvent` | `PrivateChannel('channel-update-denuncia-estatus-atendida')` | `DenunciaDependenciaServicioAmbitoRequest::sendInfo()`, `ActualizaEstadisticasARO` | Dispara listener de estadísticas |
| `ChangeStatusEvent` | `['test-channel']` | Cambio de estatus DDSA | CSS según estatus; inserta log |
| `APIDenunciaEvent` | `['api-channel']` | `ImagenAPIRequest::manage()`, `DenunciaAPIController` | Nueva denuncia mobile; inserta log |
| `IUQDenunciaEvent` | `['test-channel']` | CRUD de denuncias (trigger 0=crear, 1=modificar, 2=eliminar) | Calcula denuncias hoy/ayer/% |
| `DenunciaUpdateStatusGeneralEvent` | `PrivateChannel('channel-update-denuncia_estatus-general')` | Cambio general de estatus | Mensaje con tipo de acción |
| `DenunciaUpdateStatusGeneralAmbitoEvent` | `PrivateChannel('channel-update-denuncia_estatus-ambito-general')` | Cambios SM/AS | Notifica a ENLACE (mail deshabilitado) |
| `InserUpdateDeleteEvent` | `['test-channel']` | CRUD genérico | Payload básico `{title, power, status, msg}` |

### Listeners

| Listener | Escucha | Acción |
|----------|---------|--------|
| `ActualizaEstadisticasDenunciaListener` | `DenunciaAtendidaEvent` | Calcula semáforo, guarda `dias_*` en `denuncias`, recalcula `promedio_dias_*` en `servicios`, inserta log |
| `LogLastLogin` | `Auth\Events\Login` | Actualiza `logged=true, logged_at` en User |
| `LogLastLogout` | `Auth\Events\Logout` | Actualiza `logged=false, logout_at` en User |

### Patrón de llamada correcto a `semaforo_ultimo_estatus_off`:
```php
// onFly=true: usa estado ACTUAL de la denuncia
ActualizaEstadisticasARO::semaforo_ultimo_estatus_off(
    $den->ue_id,                              // entero, NO $den->ultimo_estatus (es relación)
    new DateTime($den->fecha_ultimo_estatus), // NO está en $dates → wrappear
    $den->fecha_ingreso                        // SÍ está en $dates → Carbon OK
);
// onFly=false: usa registro histórico DDSE
ActualizaEstadisticasARO::semaforo_ultimo_estatus_off(
    $event->viDen->estatu_id,
    $event->viDen->fecha_movimiento,  // Carbon (sí está en $dates de DDSE)
    $den->fecha_ingreso
);
```

---

## Form Requests: Patrón General

Todos los FormRequests siguen el patrón:
1. `authorize()` → siempre `true`
2. `rules()` → reglas de validación
3. `validationData()` → pre-procesa datos (uppercase, permisos ENLACE)
4. `manage()` → lógica CRUD principal
5. `attaches()` / `detaches()` → relaciones N:M
6. `failedValidation()` → retorna JSON en APIs

### Requests más importantes

| Request | Tabla/Acción | Método clave |
|---------|-------------|--------------|
| `DenunciaRequest` | `denuncias` | Valida descripcion (min:4), servicio_id; filtra dependencias para ENLACE |
| `DenunciaAmbitoRequest` | Crea/actualiza denuncia SM | `manage($ambito_dependencia)`, `attaches()` con prioridades/orígenes/deps/servicios |
| `DenunciaDependenciaServicioRequest` | DDSE normal | `manage()`: nueva DDSE o update + `VistaDenuncia` + notif FCM |
| `DenunciaDependenciaServicioAmbitoRequest` | DDSE SM/AS | `manage()`: `ChangeStatusEvent`; `sendInfo()`: `DenunciaAtendidaEvent` + broadcast + FCM |
| `ImagenAPIRequest` | `imagenes` (desde app) | `manageImage()`: decodifica base64, guarda PNG+thumb, retorna `{status, msg, url_imagen, url_thumb}` |
| `DenunciaAPIRequest` | `denunciamobile` + `denuncias` | Crea denuncia mobile + denuncia relacionada; `manageImage()` |
| `UserAPIRegistryRequest` | `users` | Crea User con roles (Invitado+CIUDADANO+CIUDADANO_INTERNET); attach permisos; UserMobile si deviceToken |
| `UbicacionRequest` | `ubicaciones` | Resuelve jerarquía: calle→colonia→comunidad→ciudad |
| `DenunciaKioskoRequest` | Kiosko | Crea denuncia con ubicacion_id=279663 fijo |

---

## Controladores Principales

### `DenunciaController`
- Gestión completa del ciclo de vida de denuncias
- `index()`: lista con filtros avanzados (FiltersRules), paginación 150
- `createItem(DenunciaRequest)`: crea denuncia
- `searchIdentical(SearchIdenticalAmbitoRequest)`: fulltext en `_viDDSs` con `string_to_tsQuery()`
- Usa vistas `_viDDSS_Viejitas` para listados

### `DenunciaDependenciaServicioAmbitoController`
- Gestiona DDSE del ámbito SM/AS
- `putEdit(DenunciaDependenciaServicioAmbitoRequest)`: guarda cambio + `DenunciaAtendidaEvent`
- Marca `fue_leida` en DDSE

### `DashboardController`
- `index()`: matriz de denuncias por dependencia/estatus
- Rango por defecto: últimos 7 días
- Retorna: `[dep_id, dep_name, abreviatura, css_class, ...estatus_counts, total]`
- Ordena por total descendente

### `UserAPIController`
- Login con lista blanca de CURP permitidos (~60 usuarios)
- Genera tokens Sanctum
- Registra `UserMobile` al autenticar desde app

### `RepDelCiuInt1AController`
- Genera Excel con 3 hojas (manipula XML del ZIP directamente)
- Sheet1: sabana de datos (~4,000 filas)
- Sheet2: totales y promedios
- Sheet3: resumen ejecutivo

---

## Frontend y UI

### Layout General
```
layouts/app.blade.php (base)
└── partials/script_header → Meta, CSS, Fonts
└── left-sidebar → Menú lateral por rol
└── topbar → Usuario, notificaciones
└── @yield('container') → contenido de cada vista
└── partials/full_modal → #modalFull (modal global AJAX)
└── partials/script_footer → JS: jQuery, DataTables, Select2, Charts, Socket.io, Echo
```

### Layouts especiales
- `app_statistics_*.blade.php` (6 variantes) → Dashboards con Chart.js, ApexCharts, Leaflet
- `app_statistics_custom_unity.blade.php` → Leaflet + Awesome Markers + Fullscreen

### Componentes Blade Clave (`resources/views/components/`)
| Componente | Uso |
|---|---|
| `catalogo.blade.php` | Wrapper estándar para listas CRUD |
| `denuncia.blade.php` | Formulario de creación/edición |
| `denuncia_ambito.blade.php` | Form para ámbito SM |
| `asignacionesV2.blade.php` | 3 paneles: sin asignar / botones / asignado |
| `asignacionesV3.blade.php` | Como V2 con búsqueda autocomplete |
| `form/form-dropzone.blade.php` | Upload con Dropzone.js |

### Patrones AJAX
```javascript
// Carga modal dinámico
$.ajax({method:"GET", url:Url}).done(function(r){ $("#modalFull .modal-content").html(r); });

// Submit con validación servidor
$.ajax({method:"PUT", url:action, data:$(this).serialize()}).done(function(r){ /* actualizar UI */ });
```

### Mapas
- **Google Maps:** API v3 con `script_google_maps.blade.php`
- **Leaflet + OSM:** con `script_leaflet_maps.blade.php`, geocoder custom en `geocoder.leaflet.maps.js`

### WebSockets
- `laravel-echo-setup.js` → configura Echo con Socket.io
- Host: `window.location.hostname:{{ env('LARAVEL_ECHO_PORT') }}`
- Canal: `channel-update-denuncia-estatus-atendida` (privado)
- Canal: `channel-update-denuncia_estatus-general` (privado)
- Canal: `test-channel` (público)

### Autocomplete Custom
- `servimun.autocomplete.js` → búsqueda AJAX de direcciones, usuarios, calles, colonias

---

## Commands Artisan (`app/Console/Commands/`)

| Comando | Archivo | Schedule |
|---------|---------|----------|
| `siac:actualiza-estadisticas-aro` | `ActualizaEstadisticasAROCommand.php` | Diario 03:00 |
| `command:name` (RefreshStatus) | `RefreshStatusDenunciasCommand.php` | Diario 02:00 |

- `--dry-run` y `--limit=N` disponibles en `siac:actualiza-estadisticas-aro`
- Cronjob: `* * * * * php artisan schedule:run >> /dev/null 2>&1`

---

## Flujo Completo de una Denuncia SM (Ámbito 2)

```
1. Ciudadano/Operador crea denuncia
   └── DenunciaAmbitoRequest::manage() → Denuncia con ambito=2, estatus_id=16 (RECIBIDA)
       └── attaches(): prioridades, orígenes, dependencias, servicios, estatus

2. Supervisor asigna a dependencia (DDSE)
   └── DenunciaDependenciaServicioAmbitoRequest::manage()
       └── Crea/actualiza registro en denuncia_dependencia_servicio_estatus
       └── Dispara ChangeStatusEvent → broadcast

3. Operador atiende (cambia estatus a 17/18/20)
   └── DenunciaDependenciaServicioAmbitoRequest::sendInfo()
       └── VistaDenunciaClass::vistaDenuncia() → sincroniza ue_id, due_id, sue_id
       └── DenunciaAtendidaEvent despachado
           └── ActualizaEstadisticasDenunciaListener::handle()
               └── semaforo_ultimo_estatus_off() → calcula días
               └── Guarda dias_atendida/rechazada/observada en denuncias
               └── Recalcula promedio_dias_* en servicios
               └── Inserta log de auditoría
               └── broadcast → frontend actualiza semáforo en tiempo real

4. Operador sube imagen de evidencia (app móvil)
   └── POST /api/v1/denuncia/agregar/imagen
       └── ImagenAPIRequest::manageImage()
           └── Decodifica base64 → PNG + thumbnail
           └── Imagene::create() + attaches (user, denuncia)
           └── Si solo_imagen=0 → crea DDSE con estatus dado
           └── Retorna {status, msg, url_imagen, url_thumb}
       └── APIDenunciaEvent despachado si status=1
```

---

## Estructura de Controladores

```
API/            → DenunciaAPI, KioskoAPI, NoticiasAPI, OperadoresAPI, UserAPI
Auth/           → Login, Register, ForgotPassword, ResetPassword, VerificationController, UsuarioCURP
Catalogos/      → Dependencia/(Area,Dependencia,Subarea), Domicilio/*, Otros/Shishe, User/*
Dashboard/      → Dashboard, DashboardEnlace, DashboardStatic(+General+Two), ServiciosMonitoreados, SMReportes, SMUnidadesAdmitivas
Denuncia/       → Denuncia, DenunciaAmbito, DenunciaCiudadana, DenunciaMobile, DenunciaOperador, Estatu, Medida, Origen, Prioridad, Servicio, ServicioCategoria, Imagene/, Respuesta/
ExcelAutollenable/ → DatosAbiertos/, ReporteDelCiuInt/(RepDelCiuInt1A), ReporteDiario/(Nov1,Nov2), ReporteSemanal/
External/       → Denuncia/(Ajax,HojaDenuncia,ListXLSX,ResumenSM), User/ListUserXLSX
Funciones/      → FuncionesController (getIp(), etc.), LoadTemplateExcel
Storage/        → Mobile/(Denuncia,Servicio), StorageDenuncia, StorageProfile, StorageRespuestaDenuncia
StreamedResponse/ → Csv/VolcadoDBtoCSV
```

## Estructura de Modelos

```
Catalogos/   → Area, Dependencia, Estatu, Medida, Origen, Prioridad, Servicio, ServicioCategoria,
               Subarea, Afiliacion, CentroLocalidad, Domicilios/*
Denuncias/   → Denuncia, DenunciaEstatu, Denuncia_Dependencia_Servicio, Denuncia_Modificado,
               Denuncia_Operador, Denuncia_Servicio, Firma, Imagene, Respuesta,
               _vi*(modelos de vistas de solo lectura)
Mobiles/     → Denunciamobile, Imagemobile, Respuestamobile, Serviciomobile
Users/       → Categoria, UserAdress, UserDataExtend, UserMobile, UserMobileMessage, UserMobileMessageRequest
app/         → User.php, Role.php, Permission.php, helpers.php
```

---

## Avances y Decisiones Técnicas

### [2026-04-28] CentroBot — Seguridad, paleta visual, campo momento, lat/lng y documentación
**Archivos modificados:**
- `routes/centrobot.php`
- `app/Http/Controllers/CentroBot/CentroBotController.php`
- `app/Http/Controllers/CentroBot/SubidaFotosController.php`
- `app/Http/Middleware/VerifyCsrfToken.php`
- `resources/views/subida_fotos.blade.php`
- `public/centrobot/index.html` *(nuevo — documentación pública)*

**Ruta generar-url-fotos: POST → GET**
- Cambiada a GET (es una consulta de lectura, no modifica estado).
- Eliminada la excepción en `VerifyCsrfToken::$except` (GET no requiere CSRF).
- `solicitud_id` ahora validado con `['required','integer','min:1']` via `$request->validate()`.

**SubidaFotosController — 4 capas de seguridad en store():**
1. Laravel `image + mimes:jpg,jpeg,png,gif,webp + max:10240` — SVG excluido (XSS).
2. `finfo(FILEINFO_MIME_TYPE)` — verifica firma binaria real (detecta extensiones cambiadas).
3. Doble extensión — analiza cada segmento del nombre original (bloquea `shell.php.jpg`).
4. Escaneo de cabecera 2 KB — detecta `<?php`, `eval(`, `<script`, etc. en metadatos EXIF.
- Propiedades `$mimesPermitidos`, `$extensionesPeligrosas`, `$patronesMaliciosos` definidas a nivel de clase.

**Campo momento (ANTES / DESPUÉS):**
- Nuevo radio button en la vista (ANTES predeterminado, DESPUÉS opcional).
- Validado en store() con `in:ANTES,DESPUÉS`; fallback a `'ANTES'` si valor inválido.
- Guardado en `Imagene::momento` al crear el registro.
- Devuelto en la respuesta JSON para actualizar el badge en la galería en tiempo real.
- Badge visual en la galería: dorado=ANTES, carmesí=DESPUÉS.

**Latitud / Longitud desde la solicitud:**
- Ya no se hardcodea `0`; se usa `$denuncia->latitud` y `$denuncia->longitud`.
- Cast a float con `(float)` y null-coalescing `?? 0` como fallback.

**Paleta de colores oficial SIAC aplicada a subida_fotos.blade.php:**
- `#96262C` (carmesí) — primario: header, folio badge, botón subir, bordes de error.
- `#987323` (dorado) — secundario: drop-zone, card-detalle, barra de progreso OK.
- `#57595A` (carbón) — neutro: footer, texto secundario.
- CSS completamente reescrito con variables CSS `--carmesi`, `--dorado`, `--carbon` y derivados.

**Drag & Drop corregido:**
- Causa: funciones `ondragover/ondragleave/ondrop` globales colisionaban con `window.on*` del DOM.
- Solución: eliminados handlers inline del div; registrados con `addEventListener` dentro de un IIFE.
- Agregado check `e.relatedTarget` en `dragleave` para evitar parpadeo al pasar sobre hijos.

**Documentación `public/centrobot/index.html`:**
- Diseño visual con paleta SIAC (carmesí, dorado, carbón).
- URL base: `http://localhost:8000` (desarrollo).
- Documenta los 3 endpoints con tablas, ejemplos JSON y cURL.
- Tabla de campos incluye `momento` (ANTES/DESPUÉS, predeterminado ANTES).
- Respuestas JSON incluyen campo `momento`.
- Sección "Otras protecciones": latitud/longitud vienen de la solicitud, no del cliente.
- 3 diagramas ASCII de flujo (generar URL, subida de fotos, flujo completo).
- Tabla de errores HTTP (404, 422, 500) con causas detalladas.
- Scroll activo en sidebar via JS sin dependencias.



### [2026-03-18] API de imágenes desde App Operador
**Archivos:** `app/Http/Requests/API/ImagenAPIRequest.php`, `app/Http/Controllers/API/DenunciaAPIController.php`

**Cambios:**
- `manageImage()` retorna array `{status, msg, url_imagen, url_thumb}` en lugar del modelo `Imagene`
- `descripcion` usa campo `observaciones` del request si viene lleno; si no, nombre del operador
- `momento` detecta `tipo_foto == "antes"` → "ANTES", cualquier otro → "DESPUÉS"
- Lógica de `attaches()` movida dentro de `manageImage()` (líneas 112-114), donde `$img` es modelo Eloquent
- `manage()` ajustado: trabaja con array de retorno, dispara `APIDenunciaEvent` solo si `status===1`
- `DenunciaUpdateStatusGeneralEvent` comentado temporalmente

**Bug corregido:** `manage()` llamaba `attaches($img)` con array → crash `TypeError`.

---

### [~2026-02] Discrepancia Reporte RepDelCiuInt1A
**Archivo:** `app/Http/Controllers/ExcelAutollenable/ReporteDelCiuInt/RepDelCiuInt1AClass.php`

**Problema:** `getOrigenes()` = 4,232 IDs únicos. Suma de `getRecibidas*()` = 4,262. Diferencia de 30 (12 relevantes).

**Causa:** Vista `_vimov_filter_sm_todas` agrupaba por `(denuncia_id, dependencia_id, servicio_id)`.
12 denuncias con dos servicios de `ServiciosPrincipales` [476,508,479,483,466,503] contaban doble.

**Solución:** Cambiar GROUP BY a `(denuncia_id, dependencia_id)`. SQL corregido en `otros/_viMovFilterTodas.sql`.
**Estado:** Pendiente aplicar en producción (usuario lo hace manualmente).

---

## [2026-04-27] — Módulo CentroBot: URL Pública de Subida de Fotos

### Objetivo
Permitir que el ciudadano suba fotos de su solicitud mediante una URL pública única
generada a partir del UUID de la denuncia. Pensado para integraciones con bots (WhatsApp, etc.).

### Estructura final creada

```
app/Http/Controllers/CentroBot/
├── CentroBotController.php      ← generarUrlSubidaFotos()
└── SubidaFotosController.php    ← show(), store(), attaches(), detaches(), saveFileAmbito()

routes/
└── centrobot.php                ← incluido desde web.php con require

resources/views/
└── subida_fotos.blade.php       ← Vista Bootstrap 5 standalone, múltiples fotos
```

### Rutas registradas (centrobot.php → incluido en web.php)

| Método | URI | Controlador | Descripción |
|--------|-----|-------------|-------------|
| GET  | `/centrobot/generar-url-fotos` | `CentroBot\CentroBotController@generarUrlSubidaFotos` | Genera la URL única para el ciudadano |
| GET  | `/{uuid}` | `CentroBot\SubidaFotosController@show` | Página pública de subida |
| POST | `/fotos/subir/{uuid}` | `CentroBot\SubidaFotosController@store` | Recibe y guarda una foto |

### Lógica de guardado de imágenes
Replica exactamente `StorageDenunciaAmbitoController`:
- Nombre: `sha1(date('YmdHis') . time()) . '-' . user_id . '-' . denuncia_id`
- Guarda original con `Storage::disk('denuncia')->put($fileName, File::get($file))`
- Genera thumbnail 128×128 y versión media 300×300 con `fitImage(..., IsRounded=true)`
- Crea `Imagene` con datos mínimos → `attaches()` (pivots imagene_user + denuncia_imagene) → `saveFileAmbito()` → `update()` con nombres de archivo
- `user__id` = `$denuncia->ciudadano_id` (propietario de la solicitud)

### Archivos modificados
- `routes/web.php` → `require __DIR__ . '/centrobot.php'` al final
- `routes/api.php` → Eliminada ruta `generar-url-fotos` (no era API)
- `app/Http/Controllers/API/DenunciaAPIController.php` → Eliminado `generarUrlSubidaFotos()`
- `app/Http/Middleware/VerifyCsrfToken.php` → Excepción para `centrobot/generar-url-fotos`

### Notas técnicas
- La ruta GET del bot (`generar-url-fotos`) no necesita CSRF (método GET, solo lectura)
- La ruta de subida de fotos SÍ tiene CSRF (se envía desde el navegador via AJAX con `_token`)
- La excepción `centrobot/generar-url-fotos` fue eliminada de `VerifyCsrfToken::$except`
- `fitImage()` recibe el UploadedFile directamente (no la ruta física)
- Los tres archivos generados: original (`.ext`), thumbnail (`_thumb_...png`), media (`_...png`)
- Pivots verificados en BD: `imagene_user` y `denuncia_imagene` se crean correctamente
- Vista soporta selección múltiple y drag & drop; sube las fotos secuencialmente con progreso individual
