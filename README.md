# Sistema Integral de Atención Ciudadana y Servicios Municipales
### SIAC — Municipio de Centro, Tabasco, México

> Plataforma web para la gestión, seguimiento y análisis de solicitudes ciudadanas y servicios municipales del Municipio de Centro, Villahermosa, Tabasco.

**Producción:** https://siac.villahermosa.gob.mx
**Desarrollado por:** @Ch50Dev — Subcoordinación de Transformación Digital e Innovación

---

## Descripción

SIAC es una aplicación web construida en Laravel que centraliza la atención ciudadana del municipio. Permite registrar solicitudes (denuncias), asignarlas a dependencias y operadores, dar seguimiento en tiempo real, generar reportes y exponer una API para aplicaciones móviles y kioscos de autoatención.

---

## Módulos Principales

| Módulo | Descripción |
|--------|-------------|
| **Denuncias** | Registro, seguimiento y cierre de solicitudes ciudadanas en tres ámbitos: Normal, Servicios Municipales (SM) y Apoyos Sociales (AS) |
| **Operadores** | Asignación de solicitudes a operadores de campo, respuestas y evidencias fotográficas desde la app móvil |
| **Dashboards** | Tableros estadísticos por dependencia, unidad administrativa y servicios monitoreados, con semáforo de tiempos de atención |
| **Reportes Excel** | Generación de reportes autollenables: Reporte Diario, Semanal, Ciudadano-Interno y Datos Abiertos |
| **Kiosko** | Punto de autoatención físico con autenticación por CURP |
| **Catálogos** | Administración de dependencias, áreas, subareas, servicios, domicilios, usuarios, roles y permisos |
| **API REST** | API v1 para apps móviles (ciudadanos y operadores) autenticada con Laravel Sanctum |

---

## Stack Tecnológico

| Herramienta | Versión / Detalle |
|---|---|
| **PHP** | 7.4 |
| **Laravel** | 7.x |
| **Base de datos** | PostgreSQL (`dbatemun`) |
| **Cache / Sesiones** | Redis (phpredis) |
| **Broadcasting** | Redis + Laravel Echo |
| **Autenticación API** | Laravel Sanctum |
| **Colas** | Driver `sync` |

---

## Requisitos

- PHP 7.4 con extensiones: `pdo_pgsql`, `redis`, `gd`, `mbstring`, `xml`, `zip`
- PostgreSQL 12+
- Redis
- Composer

---

## Instalación (Desarrollo)

```bash
# Clonar repositorio
git clone <repositorio> /var/www/servimun
cd /var/www/servimun

# Instalar dependencias
composer install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Configurar .env: DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD, REDIS_HOST

# Migraciones (si aplica)
php artisan migrate

# Enlace de almacenamiento público
php artisan storage:link

# Servidor local
php artisan serve
```

**Entorno Vagrant disponible:** IP `192.168.90.10`, directorio `/var/www/servimun`

---

## Scheduler (Tareas Automáticas)

Agregar al crontab del servidor:

```
* * * * * php artisan schedule:run >> /dev/null 2>&1
```

| Comando | Descripción | Horario |
|---------|-------------|---------|
| `siac:actualiza-estadisticas-aro` | Recalcula estadísticas de tiempos de atención SM | Diario 03:00 |
| `command:name` | Refresca estatus de denuncias | Diario 02:00 |

---

## API REST (v1)

Base URL: `/api/v1`
Autenticación: Bearer Token (Laravel Sanctum)

### Endpoints públicos

| Método | Ruta | Descripción |
|--------|------|-------------|
| `POST` | `/login` | Autenticación de usuario |
| `POST` | `/register` | Registro de nuevo usuario |
| `POST` | `/user/recovery/password` | Recuperación de contraseña |
| `POST` | `/mobile/token` | Token de dispositivo móvil |

### Endpoints protegidos (Bearer Token requerido)

| Método | Ruta | Descripción |
|--------|------|-------------|
| `GET` | `/users` | Listado de usuarios |
| `GET` | `/user/{id}` | Datos de un usuario |
| `POST` | `/denuncia/insert` | Nueva solicitud desde app |
| `POST` | `/denuncia/getlist` | Solicitudes del usuario |
| `POST` | `/denuncia/agregar/imagen` | Imagen de evidencia (operador) |
| `POST` | `/denuncia/add/respuesta` | Respuesta a solicitud |
| `POST` | `/operador/solicitudes_list` | Solicitudes asignadas al operador |
| `POST` | `/noticias/list` | Noticias del usuario |

### API Kiosko (v1b)

Base URL: `/api/v1b` — Autenticación por CURP

| Método | Ruta | Descripción |
|--------|------|-------------|
| `POST` | `/logincurp` | Login con CURP |
| `GET` | `/servicios` | Catálogo de servicios disponibles |
| `POST` | `/solicitud-kiosko-insert` | Nueva solicitud desde kiosko |

---

## Roles de Usuario

| Rol | Descripción |
|-----|-------------|
| `Administrator` / `SysOp` | Acceso total al sistema |
| `USER_OPERATOR_ADMIN` | Operador con permisos administrativos |
| `USER_OPERATOR_SIAC` | Operador de campo |
| `ENLACE` | Enlace de dependencia |
| `DELEGADOS` / `DELEGADO` | Delegado territorial |
| `COORDINACION_DE_DELEGADOS` | Coordinador de delegados |
| `USER_ARCHIVO_CAP` / `USER_ARCHIVO_ADMIN` | Gestión de archivo |
| `CIUDADANO` | Ciudadano registrado |

---

## Estructura del Proyecto

```
app/
├── Classes/Denuncia/          # Lógica de negocio (estadísticas, semáforo, vistas)
├── Console/Commands/          # Comandos Artisan programados
├── Events/ & Listeners/       # Eventos de tiempo real (WebSockets)
├── Http/
│   ├── Controllers/
│   │   ├── API/               # Controladores de la API REST
│   │   ├── Catalogos/         # Catálogos: usuarios, dependencias, domicilios
│   │   ├── Dashboard/         # Tableros estadísticos
│   │   ├── Denuncia/          # Gestión de solicitudes
│   │   └── ExcelAutollenable/ # Generación de reportes Excel
│   └── Requests/API/          # Form Requests de la API
├── Models/
│   ├── Catalogos/             # Áreas, Dependencias, Servicios, etc.
│   ├── Denuncias/             # Denuncia, DDSE, Imagenes, Respuestas
│   ├── Mobiles/               # Modelos de la app móvil
│   └── Users/                 # Extensiones del modelo User
resources/views/
├── dashboard/                 # Vistas de tableros
├── denuncia/                  # Vistas de gestión de solicitudes
├── catalogos/                 # Vistas de catálogos administrativos
└── SIAC/                      # Vistas específicas del sistema
```

---

## Variables de Entorno Clave

```env
APP_NAME="Sistema Integral de Atención Ciudadana y Servicios Municipales"
APP_NAME_SHORT="SIAC"

DB_CONNECTION=pgsql
DB_DATABASE=dbatemun

BROADCAST_DRIVER=redis
QUEUE_CONNECTION=sync

# Configuración de tiempos de atención (días)
DIAS_MAS_FECHA_INGRESO=1
DIAS_MAS_FECHA_EJECUCION=3
DIAS_MAS_FECHA_LIMITE=5

# Estatus por defecto
ESTATUS_DEFAULT_SERVICIOS_MUNICIPALES=16
ESTATUS_DEFAULT_SERVICIOS_VIEJITOS=8

# IDs de entidades clave
EMPRESA_ID=1
SAS_ID=12
```

---

## Entornos

| Entorno | URL / Ruta | Sistema |
|---------|-----------|---------|
| Desarrollo | `http://192.168.90.10` — `/var/www/servimun` | Vagrant / Ubuntu |
| Producción | https://siac.villahermosa.gob.mx | AlmaLinux / Apache |

---

*Coordinación de Transformación Digital e Innovación — Municipio de Centro, Tabasco, México*
