# Reglas del Proyecto
- Antes de implementar, asegúrate de planificar en modo plan y luego escribe.
- Ve aprendiendo constantemente como esta constituido este proyecto, su reglas de negocio, su logica, su metodologia, sus modelos, su controllers, sus request, sus vistas UI, etc.
- TODO en español
- Todos los archivos bien comentados en español.
- El repositorio github no lo toques para nada (no push, no PR, no nada).
- Siempre asegurate de que no se rompa nada.
- Para que tengas acceso a la DB local, consulta el .env y no me preguntes a cada rato cuando tengas que consultar algo.
- No borrar nada sin preguntar
- Siempre usa Agentes.
- Si tienes dudas, pregunta antes de proceder
- Si tienes que crear un nuevo archivo, asegurate de que este bien comentado y estructurado
- Asegurate de seguir al pie de la letra las reglas de este .md


## Versiones Actuales

Mantener esta sección actualizada al migrar versiones.

| Herramienta | Versión |
|---|---|
| Laravel | 7.0.9 (requiere PHP ^7.4) |
| PHP | 7.4 |
| PostgreSQL | pgsql (DB: dbatemun) |

## Entornos

- **Desarrollo:** /var/www/servimun (Vagrant/Ubuntu) — IP: 192.168.90.10
- **Producción:** https://siac.villahermosa.gob.mx/ — AlmaLinux (Apache)


---

## Reglas de Operación de Claude

### Al iniciar una sesión
1. Leer `SERVIMUN_CONTEXT.md` para tener contexto del proyecto y avances previos.
2. Consultar `.env` para credenciales de DB — no preguntar cada vez.
3. Antes de modificar cualquier archivo, leerlo completo.

### Durante el trabajo
- Verificar sintaxis PHP (`php -l`) después de cada cambio de archivo PHP.
- Ante cualquier duda sobre datos, consultar la DB directamente vía `psql` o `php artisan tinker`.
- No romper funcionalidad existente — revisar impacto en rutas, controladores y vistas relacionadas.
- No agregar código muerto, comentarios obvios ni manejo de errores para casos que no pueden ocurrir.
- Preferir editar archivos existentes sobre crear nuevos.

### Al finalizar una tarea
Actualizar la sección **"Avances y Decisiones Técnicas"** en `SERVIMUN_CONTEXT.md` con:
- Fecha `[YYYY-MM-DD]`
- Archivos modificados
- Qué se hizo y por qué
- Bugs corregidos o pendientes relevantes

### Sobre el repositorio
- **NUNCA** hacer push, pull, ni PR al repositorio GitHub.
- Commits solo cuando el usuario los solicite explícitamente.
- Formato de commit: `SIAC - C44<letra><número> | L7.30.7 Production`
