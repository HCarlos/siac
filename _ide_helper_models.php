<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Catalogos{
/**
 * App\Models\Catalogos\Afiliacion
 *
 * @property int $id
 * @property string|null $afiliacion
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Afiliacion filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Afiliacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Afiliacion newQuery()
 * @method static \Illuminate\Database\Query\Builder|Afiliacion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Afiliacion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Afiliacion whereAfiliacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Afiliacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Afiliacion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Afiliacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Afiliacion wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Afiliacion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Afiliacion withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Afiliacion withoutTrashed()
 */
	class Afiliacion extends \Eloquent {}
}

namespace App\Models\Catalogos{
/**
 * App\Models\Catalogos\Area
 *
 * @property int $id
 * @property string|null $area
 * @property int $dependencia_id
 * @property int $jefe_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $abreviatura
 * @property int $orden_impresion
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @property-read \App\Models\Catalogos\Dependencia|null $dependencia
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $dependencias
 * @property-read int|null $dependencias_count
 * @property-read \App\User $jefe
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $jefes
 * @property-read int|null $jefes_count
 * @property-read \App\Models\Catalogos\Subarea|null $subarea
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Subarea[] $subareas
 * @property-read int|null $subareas_count
 * @method static \Illuminate\Database\Eloquent\Builder|Area filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area newQuery()
 * @method static \Illuminate\Database\Query\Builder|Area onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Area query()
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereJefeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereOrdenImpresion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Area withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Area withoutTrashed()
 */
	class Area extends \Eloquent {}
}

namespace App\Models\Catalogos{
/**
 * App\Models\Catalogos\CentroLocalidad
 *
 * @property int $id
 * @property int $consecutivo
 * @property int $zona_id
 * @property string|null $zona
 * @property int $delegacion_id
 * @property string|null $prefijo_delegacion
 * @property string|null $delegacion
 * @property int $colonia_id
 * @property string|null $prefijo_colonia
 * @property string|null $colonia
 * @property int $delegado_id
 * @property bool|null $activo
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $delegado
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad newQuery()
 * @method static \Illuminate\Database\Query\Builder|CentroLocalidad onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad query()
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereColoniaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereConsecutivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereDelegacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereDelegacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereDelegadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad wherePrefijoColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad wherePrefijoDelegacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereZona($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CentroLocalidad whereZonaId($value)
 * @method static \Illuminate\Database\Query\Builder|CentroLocalidad withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CentroLocalidad withoutTrashed()
 */
	class CentroLocalidad extends \Eloquent {}
}

namespace App\Models\Catalogos{
/**
 * App\Models\Catalogos\Dependencia
 *
 * @property int $id
 * @property string|null $dependencia
 * @property string|null $abreviatura
 * @property string|null $class_css
 * @property bool|null $visible_internet
 * @property bool|null $is_areas
 * @property int $jefe_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $orden_impresion
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @property int|null $ambito_dependencia 1 = Apoyos Socialies, 2 = Servicios Municipales, 3 = Otros
 * @property-read \App\Models\Denuncias\Denuncia|null $denuncia
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia[] $denuncias
 * @property-read int|null $denuncias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $dependencia_estatus
 * @property-read int|null $dependencia_estatus_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $enlaces
 * @property-read int|null $enlaces_count
 * @property-read \App\Models\Catalogos\Estatu|null $estatu
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $estatus
 * @property-read int|null $estatus_count
 * @property-read mixed $dependencia_ambito
 * @property-read \App\User $jefe
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $servicios
 * @property-read int|null $servicios_count
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia newQuery()
 * @method static \Illuminate\Database\Query\Builder|Dependencia onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereAmbitoDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereClassCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereIsAreas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereJefeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereOrdenImpresion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependencia whereVisibleInternet($value)
 * @method static \Illuminate\Database\Query\Builder|Dependencia withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Dependencia withoutTrashed()
 */
	class Dependencia extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Asentamiento
 *
 * @property int $id
 * @property string|null $asentamiento
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $nomenclatura Se refiere el tipo de comunidad que contiene
 * @method static \Illuminate\Database\Eloquent\Builder|Asentamiento filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Asentamiento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Asentamiento newQuery()
 * @method static \Illuminate\Database\Query\Builder|Asentamiento onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Asentamiento query()
 * @method static \Illuminate\Database\Eloquent\Builder|Asentamiento whereAsentamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asentamiento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asentamiento whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asentamiento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asentamiento whereNomenclatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asentamiento wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asentamiento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Asentamiento withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Asentamiento withoutTrashed()
 */
	class Asentamiento extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Calle
 *
 * @property int $id
 * @property string|null $calle
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $calle_mig_id
 * @property string|null $searchtextcalle
 * @property bool $is_unificadora Es una clave que permite, unificar varios registros de la misma tabla e indentifica.
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @method static \Illuminate\Database\Eloquent\Builder|Calle filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Calle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Calle newQuery()
 * @method static \Illuminate\Database\Query\Builder|Calle onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Calle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Calle search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Calle whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calle whereCalleMigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calle whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calle whereIsUnificadora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calle wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calle whereSearchtextcalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Calle withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Calle withoutTrashed()
 */
	class Calle extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Ciudad
 *
 * @property int $id
 * @property string|null $ciudad
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $municipio_id
 * @property int $ciudad_mig_id
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad newQuery()
 * @method static \Illuminate\Database\Query\Builder|Ciudad onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad whereCiudad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad whereCiudadMigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad whereMunicipioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ciudad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Ciudad withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Ciudad withoutTrashed()
 */
	class Ciudad extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Codigopostal
 *
 * @property int $id
 * @property string|null $codigo
 * @property string|null $cp
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $cp_mig_id
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal newQuery()
 * @method static \Illuminate\Database\Query\Builder|Codigopostal onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal whereCodigo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal whereCpMigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Codigopostal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Codigopostal withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Codigopostal withoutTrashed()
 */
	class Codigopostal extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Colonia
 *
 * @property int $id
 * @property string|null $colonia
 * @property string|null $cp
 * @property float|null $altitud
 * @property float|null $latitud
 * @property float|null $longitud
 * @property int $codigopostal_id
 * @property int $comunidad_id
 * @property int $tipocomunidad_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $colonia_mig_id
 * @property string $nomenclatura Se refiere el tipo de comunidad que contiene
 * @property string|null $searchtextcolonia
 * @property bool $is_unificadora Es una clave que permite, unificar varios registros de la misma tabla e indentifica.
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @property-read \App\Models\Catalogos\Domicilios\Codigopostal|null $codigoPostal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Codigopostal[] $codigospostales
 * @property-read int|null $codigospostales_count
 * @property-read \App\Models\Catalogos\Domicilios\Comunidad|null $comunidad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Comunidad[] $comunidades
 * @property-read int|null $comunidades_count
 * @property-read \App\Models\Catalogos\Domicilios\Tipocomunidad|null $tipoComunidad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Tipocomunidad[] $tipocomunidades
 * @property-read int|null $tipocomunidades_count
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia newQuery()
 * @method static \Illuminate\Database\Query\Builder|Colonia onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia query()
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereAltitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereCodigopostalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereColoniaMigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereComunidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereIsUnificadora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereNomenclatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereSearchtextcolonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereTipocomunidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Colonia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Colonia withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Colonia withoutTrashed()
 */
	class Colonia extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Comunidad
 *
 * @property int $id
 * @property string|null $comunidad
 * @property int $ciudad_id
 * @property int $municipio_id
 * @property int $estado_id
 * @property int $delegado_id
 * @property int $tipocomunidad_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $comunidad_mig_id
 * @property string $nomenclatura Se refiere el tipo de comunidad que contiene
 * @property string|null $searchtextcomunidad
 * @property bool $is_unificadora Es una clave que permite, unificar varios registros de la misma tabla e indentifica.
 * @property string $ambito_comunidad RURAL, URBANO
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @property-read \App\Models\Catalogos\Domicilios\Ciudad|null $ciudad
 * @property-read \App\User|null $delegado
 * @property-read \App\Models\Catalogos\Domicilios\Estado|null $estado
 * @property-read \App\Models\Catalogos\Domicilios\Municipio|null $municipio
 * @property-read \App\Models\Catalogos\Domicilios\Tipocomunidad|null $tipoComunidad
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad newQuery()
 * @method static \Illuminate\Database\Query\Builder|Comunidad onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereAmbitoComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereCiudadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereComunidadMigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereDelegadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereEstadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereIsUnificadora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereMunicipioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereNomenclatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereSearchtextcomunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereTipocomunidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comunidad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Comunidad withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Comunidad withoutTrashed()
 */
	class Comunidad extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Estado
 *
 * @property int $id
 * @property string|null $estado
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $estado_mig_id
 * @property string|null $searchtextestado
 * @method static \Illuminate\Database\Eloquent\Builder|Estado filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Estado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Estado newQuery()
 * @method static \Illuminate\Database\Query\Builder|Estado onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Estado query()
 * @method static \Illuminate\Database\Eloquent\Builder|Estado search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Estado whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estado whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estado whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estado whereEstadoMigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estado whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estado wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estado whereSearchtextestado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estado whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Estado withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Estado withoutTrashed()
 */
	class Estado extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Localidad
 *
 * @property int $id
 * @property string|null $localidad
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $localidad_mig_id
 * @property string|null $searchtextlocalidad
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad newQuery()
 * @method static \Illuminate\Database\Query\Builder|Localidad onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereLocalidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereLocalidadMigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereSearchtextlocalidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Localidad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Localidad withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Localidad withoutTrashed()
 */
	class Localidad extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Municipio
 *
 * @property int $id
 * @property string|null $municipio
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $estado_id
 * @property int $numero_municipio
 * @property int $municipio_mig_id
 * @property string|null $searchtextmunicipio
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio newQuery()
 * @method static \Illuminate\Database\Query\Builder|Municipio onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio query()
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereEstadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereMunicipio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereMunicipioMigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereNumeroMunicipio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereSearchtextmunicipio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Municipio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Municipio withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Municipio withoutTrashed()
 */
	class Municipio extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Pais
 *
 * @property int $id
 * @property string|null $pais
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Pais newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pais newQuery()
 * @method static \Illuminate\Database\Query\Builder|Pais onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pais query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pais whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pais whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pais whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pais wherePais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pais wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pais whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Pais withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Pais withoutTrashed()
 */
	class Pais extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Sepomex
 *
 * @property int $id
 * @property string|null $zona
 * @property int $asentamiento_id
 * @property int $tipoasentamiento_id
 * @property int $codigospostal_id
 * @property int $municipio_id
 * @property int $estado_id
 * @property int $ciudad_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Catalogos\Domicilios\Asentamiento|null $Asentamiento
 * @property-read \App\Models\Catalogos\Domicilios\Ciudad|null $Ciudad
 * @property-read \App\Models\Catalogos\Domicilios\Codigopostal|null $CodigoPostal
 * @property-read \App\Models\Catalogos\Domicilios\Estado|null $Estado
 * @property-read \App\Models\Catalogos\Domicilios\Municipio|null $Municipio
 * @property-read \App\Models\Catalogos\Domicilios\Tipoasentamiento|null $TipoAsentamiento
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex newQuery()
 * @method static \Illuminate\Database\Query\Builder|Sepomex onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex whereAsentamientoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex whereCiudadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex whereCodigospostalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex whereEstadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex whereMunicipioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex whereTipoasentamientoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sepomex whereZona($value)
 * @method static \Illuminate\Database\Query\Builder|Sepomex withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Sepomex withoutTrashed()
 */
	class Sepomex extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Tipoasentamiento
 *
 * @property int $id
 * @property string|null $tipoasentamiento
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $nomenclatura Se refiere el tipo de comunidad que contiene
 * @method static \Illuminate\Database\Eloquent\Builder|Tipoasentamiento filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipoasentamiento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tipoasentamiento newQuery()
 * @method static \Illuminate\Database\Query\Builder|Tipoasentamiento onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tipoasentamiento query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tipoasentamiento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipoasentamiento whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipoasentamiento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipoasentamiento whereNomenclatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipoasentamiento wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipoasentamiento whereTipoasentamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipoasentamiento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Tipoasentamiento withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Tipoasentamiento withoutTrashed()
 */
	class Tipoasentamiento extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Tipocomunidad
 *
 * @property int $id
 * @property string|null $tipocomunidad
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $nomenclatura Se refiere el tipo de comunidad que contiene
 * @method static \Illuminate\Database\Eloquent\Builder|Tipocomunidad filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipocomunidad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tipocomunidad newQuery()
 * @method static \Illuminate\Database\Query\Builder|Tipocomunidad onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tipocomunidad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tipocomunidad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipocomunidad whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipocomunidad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipocomunidad whereNomenclatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipocomunidad wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipocomunidad whereTipocomunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tipocomunidad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Tipocomunidad withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Tipocomunidad withoutTrashed()
 */
	class Tipocomunidad extends \Eloquent {}
}

namespace App\Models\Catalogos\Domicilios{
/**
 * App\Models\Catalogos\Domicilios\Ubicacion
 *
 * @property int $id
 * @property \App\Models\Catalogos\Domicilios\Calle|null $calle
 * @property string|null $num_ext
 * @property string|null $num_int
 * @property \App\Models\Catalogos\Domicilios\Colonia|null $colonia
 * @property \App\Models\Catalogos\Domicilios\Localidad|null $comunidad
 * @property \App\Models\Catalogos\Domicilios\Ciudad|null $ciudad
 * @property \App\Models\Catalogos\Domicilios\Municipio|null $municipio
 * @property \App\Models\Catalogos\Domicilios\Estado|null $estado
 * @property string|null $pais
 * @property string|null $cp
 * @property float|null $latitud
 * @property float|null $longitud
 * @property int|null $calle_id
 * @property int|null $colonia_id
 * @property int|null $comunidad_id
 * @property int|null $ciudad_id
 * @property int|null $municipio_id
 * @property int|null $estado_id
 * @property int|null $codigopostal_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $searchtext
 * @property string $g_calle
 * @property string $g_num_ext
 * @property string $g_num_int
 * @property string $g_colonia
 * @property string $g_comunidad
 * @property string $g_ciudad
 * @property string $g_municipio
 * @property string $g_estado
 * @property string $g_cp
 * @property string $search_google
 * @property string $g_ubicacion
 * @property float|null $altitud
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @property string|null $g_searchtext
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Calle[] $calles
 * @property-read int|null $calles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Ciudad[] $ciudades
 * @property-read int|null $ciudades_count
 * @property-read \App\Models\Catalogos\Domicilios\Codigopostal|null $codigopostal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Codigopostal[] $codigospostales
 * @property-read int|null $codigospostales_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Colonia[] $colonias
 * @property-read int|null $colonias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Comunidad[] $comunidades
 * @property-read int|null $comunidades_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Estado[] $estados
 * @property-read int|null $estados_count
 * @property-read mixed $ubicacion
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Municipio[] $municipios
 * @property-read int|null $municipios_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion filterBy($filerts)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion newQuery()
 * @method static \Illuminate\Database\Query\Builder|Ubicacion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereAltitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereCalleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereCiudad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereCiudadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereCodigopostalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereColoniaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereComunidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereEstadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereGCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereGCiudad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereGColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereGComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereGCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereGEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereGMunicipio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereGNumExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereGNumInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereGSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereGUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereMunicipio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereMunicipioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereNumExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereNumInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion wherePais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereSearchGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubicacion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Ubicacion withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Ubicacion withoutTrashed()
 */
	class Ubicacion extends \Eloquent {}
}

namespace App\Models\Catalogos{
/**
 * App\Models\Catalogos\Estatu
 *
 * @property int $id
 * @property string|null $estatus
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $abreviatura
 * @property int $orden_impresion
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @property bool $resuelto 0=No
 * @property bool $favorable
 * @property int $ambito_estatus
 * @property bool $requiere_imagen Pregunta si es necesario agregar una imagen
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $denuncia_dependencias
 * @property-read int|null $denuncia_dependencias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia[] $denuncias
 * @property-read int|null $denuncias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $dependencias
 * @property-read int|null $dependencias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $servicios
 * @property-read int|null $servicios_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu newQuery()
 * @method static \Illuminate\Database\Query\Builder|Estatu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereAmbitoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereFavorable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereOrdenImpresion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereRequiereImagen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereResuelto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estatu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Estatu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Estatu withoutTrashed()
 */
	class Estatu extends \Eloquent {}
}

namespace App\Models\Catalogos{
/**
 * App\Models\Catalogos\Medida
 *
 * @property int $id
 * @property string|null $medida
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Medida filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Medida newQuery()
 * @method static \Illuminate\Database\Query\Builder|Medida onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Medida query()
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereMedida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Medida whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Medida withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Medida withoutTrashed()
 */
	class Medida extends \Eloquent {}
}

namespace App\Models\Catalogos{
/**
 * App\Models\Catalogos\Origen
 *
 * @property int $id
 * @property string|null $origen
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Origen filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Origen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Origen newQuery()
 * @method static \Illuminate\Database\Query\Builder|Origen onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Origen query()
 * @method static \Illuminate\Database\Eloquent\Builder|Origen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Origen whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Origen whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Origen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Origen whereOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Origen wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Origen whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Origen withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Origen withoutTrashed()
 */
	class Origen extends \Eloquent {}
}

namespace App\Models\Catalogos{
/**
 * App\Models\Catalogos\Prioridad
 *
 * @property int $id
 * @property string|null $prioridad
 * @property bool|null $predeterminado
 * @property string|null $class_css
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @property int $orden_impresion
 * @property int $ambito_prioridad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad newQuery()
 * @method static \Illuminate\Database\Query\Builder|Prioridad onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad query()
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad whereAmbitoPrioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad whereClassCss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad whereOrdenImpresion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad wherePrioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Prioridad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Prioridad withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Prioridad withoutTrashed()
 */
	class Prioridad extends \Eloquent {}
}

namespace App\Models\Catalogos{
/**
 * App\Models\Catalogos\Servicio
 *
 * @property int $id
 * @property string|null $servicio
 * @property bool|null $habilitado
 * @property int $medida_id
 * @property int $subarea_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $orden_impresion
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @property string|null $searchtextservicio
 * @property bool $is_visible_mobile
 * @property string $nombre_mobile
 * @property string $root
 * @property string $filename
 * @property string $filename_png
 * @property string $filename_thumb
 * @property string $url_image_mobile
 * @property int $orden_image_mobile
 * @property string $ambito_servicio RURAL, URBANO
 * @property string $nombre_corto_ss Nombre corto para estadisticos
 * @property int|null $nombre_corto_orden_ss
 * @property bool $is_visible_nombre_corto_ss
 * @property int $dias_ejecucion Los días que se tardará en ejecutar dicho servicio
 * @property int $dias_maximos_ejecucion Los días máximos que se tardará en ejecutar dicho servicio
 * @property float $promedio_dias_atendida Los días promedios en ser atendidas
 * @property float $promedio_dias_rechazada Los días promedios en ser rechazada
 * @property float $promedio_dias_observada Los días promedios en ser observada
 * @property-read \App\Models\Catalogos\Area|null $area
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia[] $denuncias
 * @property-read int|null $denuncias_count
 * @property-read \App\Models\Catalogos\Dependencia|null $dependencia
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $dependencias
 * @property-read int|null $dependencias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $estatus
 * @property-read int|null $estatus_count
 * @property-read mixed $path_image
 * @property-read mixed $path_image_thumb
 * @property-read \App\Models\Catalogos\Medida|null $medida
 * @property-read \App\Models\Catalogos\Subarea|null $subarea
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Subarea[] $subareas
 * @property-read int|null $subareas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio newQuery()
 * @method static \Illuminate\Database\Query\Builder|Servicio onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio query()
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereAmbitoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereFilenamePng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereFilenameThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereIsVisibleMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereIsVisibleNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereMedidaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereNombreCortoOrdenSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereNombreMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereOrdenImageMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereOrdenImpresion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio wherePromedioDiasAtendida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio wherePromedioDiasObservada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio wherePromedioDiasRechazada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereRoot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereSearchtextservicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereSubareaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Servicio whereUrlImageMobile($value)
 * @method static \Illuminate\Database\Query\Builder|Servicio withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Servicio withoutTrashed()
 */
	class Servicio extends \Eloquent {}
}

namespace App\Models\Catalogos{
/**
 * App\Models\Catalogos\ServicioCategoria
 *
 * @property int $id
 * @property string|null $categoria_servicios
 * @property string|null $enlaces_unidades
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|ServicioCategoria filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicioCategoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicioCategoria newQuery()
 * @method static \Illuminate\Database\Query\Builder|ServicioCategoria onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicioCategoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicioCategoria whereCategoriaServicios($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicioCategoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicioCategoria whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicioCategoria whereEnlacesUnidades($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicioCategoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicioCategoria wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicioCategoria whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ServicioCategoria withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ServicioCategoria withoutTrashed()
 */
	class ServicioCategoria extends \Eloquent {}
}

namespace App\Models\Catalogos{
/**
 * App\Models\Catalogos\Subarea
 *
 * @property int $id
 * @property string|null $subarea
 * @property int $area_id
 * @property int $jefe_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $abreviatura
 * @property int $orden_impresion
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @property-read \App\Models\Catalogos\Area|null $area
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Area[] $areas
 * @property-read int|null $areas_count
 * @property-read \App\Models\Catalogos\Dependencia|null $dependencia
 * @property-read \App\User|null $jefe
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $jefes
 * @property-read int|null $jefes_count
 * @property-read \App\Models\Catalogos\Servicio|null $servicio
 * @property-read \App\Models\Catalogos\Servicio|null $servicios
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea newQuery()
 * @method static \Illuminate\Database\Query\Builder|Subarea onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea whereJefeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea whereOrdenImpresion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea whereSubarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subarea whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Subarea withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Subarea withoutTrashed()
 */
	class Subarea extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\Denuncia
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $fecha_ingreso
 * @property string|null $cantidad
 * @property string|null $descripcion
 * @property string|null $referencia
 * @property string|null $oficio_envio
 * @property string|null $fecha_oficio_dependencia
 * @property string|null $fecha_limite
 * @property string|null $fecha_ejecucion
 * @property string|null $calle
 * @property string|null $num_ext
 * @property string|null $num_int
 * @property string|null $colonia
 * @property string|null $comunidad
 * @property string|null $ciudad
 * @property string|null $municipio
 * @property string|null $estado
 * @property string|null $pais
 * @property string|null $cp
 * @property float|null $latitud
 * @property float|null $longitud
 * @property int|null $status_denuncia
 * @property int|null $prioridad_id
 * @property int|null $origen_id
 * @property int|null $dependencia_id
 * @property int|null $ubicacion_id
 * @property int|null $servicio_id
 * @property int|null $estatus_id
 * @property int|null $ciudadano_id
 * @property int|null $empresa_id
 * @property int|null $creadopor_id
 * @property int|null $modificadopor_id
 * @property string|null $ip
 * @property string|null $host
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $searchtextdenuncia
 * @property string $domicilio_ciudadano_internet
 * @property string $observaciones
 * @property bool $cerrado
 * @property \Illuminate\Support\Carbon $fecha_cerrado
 * @property int|null $cerradopor_id
 * @property bool $firmado
 * @property string $uuid
 * @property string $folio_sas Se refiere folio interno de SAS
 * @property bool $favorable Evalua si al cerrar, fue favorable o no
 * @property string $clave_identificadora Es una clave que permite, identificar un paquete, comunicdad ó programa en especial.
 * @property int|null $denunciamobile_id
 * @property int $ambito 0=No Aplica, 1=Urbana, 2=Rural
 * @property string $estatus_general Guardael estatus general de la denuncia
 * @property int $ue_id Guarda el último estatus
 * @property int $due_id Guarda la dependencia del último estatus
 * @property int $sue_id Guarda elservicio del último estatus
 * @property string $fecha_ultimo_estatus Guarda la fecha del último estatus
 * @property string $search_google
 * @property string $gd_ubicacion
 * @property float|null $altitud
 * @property string|null $gd_searchtext
 * @property int|null $centro_localidad_id Guarda el ID de la tabla Centro_Localidad
 * @property int $dias_atendida Los dias que se tardó en ser atendidas
 * @property int $dias_rechazada Los dias que se tardó en ser rechazada
 * @property int $dias_observada Los dias que se tardó en ser observada
 * @property string $codigo_postal_manual Guarda el codigo postal manual
 * @property string $search_google_select Dirección google seleccionada
 * @property string|null $calle_y_numero_searchtext
 * @property-read \App\Models\Catalogos\Domicilios\Ubicacion|null $UbicacMe
 * @property-read \App\User|null $cerradopor
 * @property-read \App\User|null $ciudadano
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $ciudadanos
 * @property-read int|null $ciudadanos_count
 * @property-read \App\User|null $creadopor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $creadospor
 * @property-read int|null $creadospor_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $denuncia_dependencias
 * @property-read int|null $denuncia_dependencias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $denuncia_estatus
 * @property-read int|null $denuncia_estatus_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia_Modificado[] $denuncia_modificado
 * @property-read int|null $denuncia_modificado_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $denuncia_servicios
 * @property-read int|null $denuncia_servicios_count
 * @property-read \App\Models\Catalogos\Dependencia|null $dependencia
 * @property-read \App\Models\Catalogos\Dependencia|null $dependencia_ultimo_estatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $dependencias
 * @property-read int|null $dependencias_count
 * @property-read \App\Models\Catalogos\Estatu|null $estatu
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $estatus
 * @property-read int|null $estatus_count
 * @property-read \App\Models\Denuncias\Firma|null $firma
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Firma[] $firmas
 * @property-read int|null $firmas_count
 * @property-read mixed $fecha_ingreso_solicitud
 * @property-read mixed $folio_dac
 * @property-read mixed $full_ubication
 * @property-read mixed $localidad_centro
 * @property-read mixed $total_respuestas
 * @property-read mixed $ultima_dependencia
 * @property-read mixed $ultima_fecha_estatus
 * @property-read mixed $ultima_respuesta
 * @property-read mixed $ultimo_servicio
 * @property-read mixed $ultimos_estatus
 * @property-read \App\Models\Denuncias\Imagene|null $imagene
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Imagene[] $imagenes
 * @property-read int|null $imagenes_count
 * @property-read \App\User|null $modificadopor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $modificadospor
 * @property-read int|null $modificadospor_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $operadores
 * @property-read int|null $operadores_count
 * @property-read \App\Models\Catalogos\Origen|null $origen
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Origen[] $origenes
 * @property-read int|null $origenes_count
 * @property-read \App\Models\Catalogos\Prioridad|null $prioridad
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Prioridad[] $prioridades
 * @property-read int|null $prioridades_count
 * @property-read \App\Models\Denuncias\Respuesta|null $respuesta
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Respuesta[] $respuestas
 * @property-read int|null $respuestas_count
 * @property-read \App\Models\Catalogos\Servicio|null $servicio
 * @property-read \App\Models\Catalogos\Servicio|null $servicio_ultimo_estatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $servicios
 * @property-read int|null $servicios_count
 * @property-read \App\Models\Catalogos\Domicilios\Ubicacion|null $ubicacion
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Ubicacion[] $ubicaciones
 * @property-read int|null $ubicaciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia_Dependencia_Servicio[] $ultimo_estatu_denuncia_dependencia_servicio
 * @property-read int|null $ultimo_estatu_denuncia_dependencia_servicio_count
 * @property-read \App\Models\Catalogos\Estatu|null $ultimo_estatus
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia ambitoFilterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia filterByCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia getDenunciasAmbitoFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia getDenunciasAmbitoItemCustomFilter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia getDenunciasEstatusAmbitoFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia getDenunciasFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia getDenunciasItemCustomFilter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia hasEstatuDependencia()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia newQuery()
 * @method static \Illuminate\Database\Query\Builder|Denuncia onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia query()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereAltitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereAmbito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCalleYNumeroSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCentroLocalidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCerrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCerradoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCiudad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCiudadanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereClaveIdentificadora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCodigoPostalManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCreadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereDenunciamobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereDiasAtendida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereDiasObservada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereDiasRechazada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereDomicilioCiudadanoInternet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereDueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereEmpresaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereEstatusGeneral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereEstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereFavorable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereFechaCerrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereFechaEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereFechaIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereFechaLimite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereFechaOficioDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereFechaUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereFirmado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereFolioSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereGdSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereGdUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereModificadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereMunicipio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereNumExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereNumInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereOficioEnvio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereOrigenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia wherePais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia wherePrioridadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereSearchGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereSearchGoogleSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereSearchtextdenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereStatusDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereSueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereUbicacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereUeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|Denuncia withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Denuncia withoutTrashed()
 */
	class Denuncia extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\DenunciaEstatu
 *
 * @property int $id
 * @property int $denuncia_id
 * @property int $estatus_id
 * @property bool|null $ultimo
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|DenunciaEstatu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DenunciaEstatu newQuery()
 * @method static \Illuminate\Database\Query\Builder|DenunciaEstatu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DenunciaEstatu query()
 * @method static \Illuminate\Database\Eloquent\Builder|DenunciaEstatu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DenunciaEstatu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DenunciaEstatu whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DenunciaEstatu whereEstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DenunciaEstatu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DenunciaEstatu whereUltimo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DenunciaEstatu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|DenunciaEstatu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DenunciaEstatu withoutTrashed()
 */
	class DenunciaEstatu extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\Denuncia_Dependencia_Servicio
 *
 * @property int $id
 * @property int $denuncia_id
 * @property int $dependencia_id
 * @property int $servicio_id
 * @property int $estatu_id
 * @property string|null $observaciones
 * @property \Illuminate\Support\Carbon|null $fecha_movimiento
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $favorable Evalua si al cerrar, fue favorable o no
 * @property bool $fue_leida Evalúa si ya fue leida por el área correspondiente.
 * @property int|null $creadopor_id
 * @property-read \App\User|null $creadopor
 * @property-read \App\Models\Denuncias\Denuncia|null $denuncia
 * @property-read \App\Models\Catalogos\Dependencia|null $dependencia
 * @property-read \App\Models\Catalogos\Estatu|null $estatu
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Imagene[] $imagenes
 * @property-read int|null $imagenes_count
 * @property-read \App\Models\Catalogos\Servicio|null $servicio
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio newQuery()
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Dependencia_Servicio onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio query()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereCreadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereEstatuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereFavorable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereFechaMovimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereFueLeida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Dependencia_Servicio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Dependencia_Servicio withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Dependencia_Servicio withoutTrashed()
 */
	class Denuncia_Dependencia_Servicio extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\Denuncia_Modificado
 *
 * @property int $id
 * @property int $denuncia_id
 * @property int $modificadopor_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $campos_modificados Guarda los campos modificados
 * @property string $antes valores antes
 * @property string $despues valores después
 * @property-read \App\Models\Denuncias\Denuncia|null $denuncia
 * @property-read \App\User|null $modificadopor
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado newQuery()
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Modificado onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado query()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado whereAntes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado whereCamposModificados($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado whereDespues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado whereModificadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Modificado whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Modificado withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Modificado withoutTrashed()
 */
	class Denuncia_Modificado extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\Denuncia_Operador
 *
 * @property int $id
 * @property int $operador_id
 * @property int $denuncia_id
 * @property int $orden
 * @property string $fecha_asignacion
 * @property string $fecha_ejecucion
 * @property string|null $observaciones
 * @property bool|null $cerrada
 * @property bool|null $predeterminado
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Denuncias\Denuncia|null $denuncia
 * @property-read \App\User|null $operador
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador newQuery()
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Operador onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador query()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador whereCerrada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador whereFechaAsignacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador whereFechaEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador whereOperadorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador wherePredeterminado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Operador whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Operador withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Operador withoutTrashed()
 */
	class Denuncia_Operador extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\Denuncia_Servicio
 *
 * @property int $id
 * @property int $denuncia_id
 * @property int $servicio_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Denuncias\Denuncia|null $denuncia
 * @property-read \App\Models\Catalogos\Servicio|null $servicio
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Servicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Servicio newQuery()
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Servicio onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Servicio query()
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Servicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Servicio whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Servicio whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Servicio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Servicio whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denuncia_Servicio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Servicio withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Denuncia_Servicio withoutTrashed()
 */
	class Denuncia_Servicio extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\Firma
 *
 * @property int $id
 * @property string $archivo_cer
 * @property string $sello_cer
 * @property string $archivo_key
 * @property string $sello_key
 * @property string $password
 * @property string $cadena_original
 * @property string $hash
 * @property string $sello
 * @property bool $valido
 * @property \Illuminate\Support\Carbon $fecha_firmado
 * @property \App\User|null $firmadopor_id
 * @property string|null $ip
 * @property string|null $host
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Denuncias\Denuncia|null $denuncia
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia[] $denuncias
 * @property-read int|null $denuncias_count
 * @method static \Illuminate\Database\Eloquent\Builder|Firma newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Firma newQuery()
 * @method static \Illuminate\Database\Query\Builder|Firma onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Firma query()
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereArchivoCer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereArchivoKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereCadenaOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereFechaFirmado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereFirmadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereSello($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereSelloCer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereSelloKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Firma whereValido($value)
 * @method static \Illuminate\Database\Query\Builder|Firma withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Firma withoutTrashed()
 */
	class Firma extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\Imagene
 *
 * @property int $id
 * @property string|null $fecha
 * @property string|null $root
 * @property string|null $image
 * @property string|null $image_thumb
 * @property string|null $titulo
 * @property string|null $descripcion
 * @property string|null $momento
 * @property int $user__id
 * @property int $denuncia__id
 * @property int $parent__id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float|null $altitud
 * @property float|null $latitud
 * @property float|null $longitud
 * @property-read Imagene|null $child
 * @property-read \Illuminate\Database\Eloquent\Collection|Imagene[] $childs
 * @property-read int|null $childs_count
 * @property-read \App\Models\Denuncias\Denuncia|null $denuncia
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia[] $denuncias
 * @property-read int|null $denuncias_count
 * @property-read mixed $path_image
 * @property-read mixed $path_image_mobile
 * @property-read mixed $path_image_mobile_thumb
 * @property-read mixed $path_image_thumb
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia_Dependencia_Servicio[] $respuestas
 * @property-read int|null $respuestas_count
 * @property-read \App\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene newQuery()
 * @method static \Illuminate\Database\Query\Builder|Imagene onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene query()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereAltitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereImageThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereMomento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereRoot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagene whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Imagene withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Imagene withoutTrashed()
 */
	class Imagene extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\Respuesta
 *
 * @property int $id
 * @property string|null $fecha
 * @property string|null $respuesta
 * @property string|null $observaciones
 * @property int $user__id
 * @property int $denuncia__id
 * @property int $parent__id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Respuesta|null $child
 * @property-read \Illuminate\Database\Eloquent\Collection|Respuesta[] $childs
 * @property-read int|null $childs_count
 * @property-read \App\Models\Denuncias\Denuncia|null $denuncia
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia[] $denuncias
 * @property-read int|null $denuncias_count
 * @property-read \App\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta newQuery()
 * @method static \Illuminate\Database\Query\Builder|Respuesta onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta query()
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta whereRespuesta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuesta whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Respuesta withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Respuesta withoutTrashed()
 */
	class Respuesta extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\_viDDSS_Viejitas
 *
 * @property int|null $id
 * @property string|null $fecha_ingreso
 * @property string|null $cantidad
 * @property string|null $denuncia
 * @property string|null $referencia
 * @property string|null $oficio_envio
 * @property string|null $fecha_oficio_dependencia
 * @property string|null $fecha_limite
 * @property string|null $fecha_ejecucion
 * @property string|null $calle
 * @property string|null $num_ext
 * @property string|null $num_int
 * @property string|null $colonia
 * @property string|null $comunidad
 * @property string|null $cp
 * @property \App\Models\Catalogos\Domicilios\Ubicacion|null $ubicacion
 * @property string|null $search_google
 * @property string|null $gd_ubicacion
 * @property string|null $gd_searchtext
 * @property string|null $calle_y_numero_searchtext
 * @property float|null $latitud
 * @property float|null $longitud
 * @property string|null $lati1
 * @property string|null $long1
 * @property string|null $lati2
 * @property string|null $long2
 * @property string|null $lati3
 * @property string|null $long3
 * @property string|null $lati4
 * @property string|null $long4
 * @property string|null $lati5
 * @property string|null $long5
 * @property float|null $altitud
 * @property int|null $ubicacion_id
 * @property int|null $estatus_id
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $estatus
 * @property int|null $estatus_resuelto
 * @property int|null $estatus_habilitado
 * @property int|null $status_denuncia
 * @property int|null $prioridad_id
 * @property \App\Models\Catalogos\Prioridad|null $prioridad
 * @property int|null $prioridad_habilitada
 * @property int|null $origen_id
 * @property \App\Models\Catalogos\Origen|null $origen
 * @property int|null $origen_habilitado
 * @property int|null $servicio_id
 * @property \App\Models\Catalogos\Servicio|null $servicio
 * @property bool|null $habilitado
 * @property int|null $medida_id
 * @property int|null $subarea_id
 * @property string|null $subarea
 * @property int|null $subarea_habilitada
 * @property int|null $area_id
 * @property string|null $area
 * @property int|null $area_habilitada
 * @property int|null $dependencia_id
 * @property \App\Models\Catalogos\Dependencia|null $dependencia
 * @property string|null $abreviatura
 * @property int|null $ambito_dependencia
 * @property int|null $dependencia_habilitada
 * @property int|null $ciudadano_id
 * @property string|null $username
 * @property string|null $ap_paterno_ciudadano
 * @property string|null $ap_materno_ciudadano
 * @property string|null $nombre_ciudadano
 * @property \App\User|null $ciudadano
 * @property int|null $genero
 * @property string|null $genero_ciudadano
 * @property int|null $creadopor_id
 * @property \App\User|null $creadopor
 * @property string|null $curp_creadopor
 * @property int|null $modificadopor_id
 * @property \App\User|null $modificadopor
 * @property string|null $curp_modificadopor
 * @property string|null $celulares
 * @property string|null $telefonos
 * @property string|null $email
 * @property string|null $telefonoscelularesemails
 * @property string|null $curp_ciudadano
 * @property string|null $searchtext_ciudadano
 * @property string|null $domicilio_ciudadano_internet
 * @property string|null $observaciones
 * @property bool|null $cerrado
 * @property string|null $fecha_cerrado
 * @property int|null $cerradopor_id
 * @property \App\User|null $cerradopor
 * @property string|null $curp_cerradopor
 * @property bool|null $firmado
 * @property string|null $uuid
 * @property string|null $folio_sas
 * @property bool|null $favorable
 * @property string|null $clave_identificadora
 * @property int|null $denunciamobile_id
 * @property int|null $ambito
 * @property string|null $ambito_sas
 * @property int|null $servicio_habilitado
 * @property string|null $ambito_servicio
 * @property string|null $estatus_general
 * @property int|null $ue_id
 * @property \App\Models\Catalogos\Estatu|null $ultimo_estatus
 * @property string|null $fecha_ultimo_estatus
 * @property int|null $ultimo_estatus_resuelto
 * @property int|null $due_id
 * @property \App\Models\Catalogos\Dependencia|null $dependencia_ultimo_estatus
 * @property int|null $sue_id
 * @property \App\Models\Catalogos\Servicio|null $servicio_ultimo_estatus
 * @property string|null $searchtextdenuncia
 * @property bool|null $is_visible_mobile
 * @property string|null $nombre_mobile
 * @property int|null $orden_image_mobile
 * @property string|null $nombre_corto_ss
 * @property int|null $nombre_corto_orden_ss
 * @property bool|null $is_visible_nombre_corto_ss
 * @property int|null $dias_ejecucion
 * @property int|null $dias_maximos_ejecucion
 * @property string|null $fecha_dias_ejecucion
 * @property string|null $fecha_dias_maximos_ejecucion
 * @property int|null $centro_localidad_id
 * @property int|null $dias_atendida
 * @property int|null $dias_rechazada
 * @property int|null $dias_observada
 * @property string|null $codigo_postal_manual
 * @property string|null $search_google_select
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $ciudadanos
 * @property-read int|null $ciudadanos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $creadospor
 * @property-read int|null $creadospor_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $denuncia_dependencias
 * @property-read int|null $denuncia_dependencias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $denuncia_estatus
 * @property-read int|null $denuncia_estatus_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $denuncia_servicios
 * @property-read int|null $denuncia_servicios_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $dependencias
 * @property-read int|null $dependencias_count
 * @property-read \App\Models\Catalogos\Estatu|null $estatu
 * @property-read int|null $estatus_count
 * @property-read \App\Models\Denuncias\Firma|null $firma
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Firma[] $firmas
 * @property-read int|null $firmas_count
 * @property-read mixed $fecha_ingreso_solicitud
 * @property-read mixed $folio_dac
 * @property-read mixed $full_ubication
 * @property-read mixed $total_respuestas
 * @property-read mixed $ultima_dependencia
 * @property-read mixed $ultima_fecha_estatus
 * @property-read mixed $ultima_respuesta
 * @property-read mixed $ultimo_servicio
 * @property-read mixed $ultimos_estatus
 * @property-read \App\Models\Denuncias\Imagene|null $imagene
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Imagene[] $imagenes
 * @property-read int|null $imagenes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $modificadospor
 * @property-read int|null $modificadospor_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Origen[] $origenes
 * @property-read int|null $origenes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Prioridad[] $prioridades
 * @property-read int|null $prioridades_count
 * @property-read \App\Models\Denuncias\Respuesta|null $respuesta
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Respuesta[] $respuestas
 * @property-read int|null $respuestas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $servicios
 * @property-read int|null $servicios_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Ubicacion[] $ubicaciones
 * @property-read int|null $ubicaciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia_Dependencia_Servicio[] $ultimo_estatu_denuncia_dependencia_servicio
 * @property-read int|null $ultimo_estatu_denuncia_dependencia_servicio_count
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas ambitoFilterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas filterByCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas getDenunciasAmbitoFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas getDenunciasAmbitoItemCustomFilter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas getDenunciasEstatusAmbitoFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas getDenunciasItemCustomFilter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas query()
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereAltitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereAmbito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereAmbitoDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereAmbitoSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereAmbitoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereApMaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereApPaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereAreaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCalleYNumeroSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCelulares($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCentroLocalidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCerrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCerradopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCerradoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCiudadanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereClaveIdentificadora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCodigoPostalManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCreadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCreadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCurpCerradopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCurpCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCurpCreadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereCurpModificadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDenunciamobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDependenciaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDependenciaUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDiasAtendida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDiasObservada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDiasRechazada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDomicilioCiudadanoInternet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereDueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereEstatusGeneral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereEstatusHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereEstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereEstatusResuelto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereFavorable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereFechaCerrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereFechaDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereFechaDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereFechaEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereFechaIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereFechaLimite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereFechaOficioDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereFechaUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereFirmado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereFolioSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereGdSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereGdUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereGenero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereGeneroCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereIsVisibleMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereIsVisibleNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLati1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLati2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLati3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLati4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLati5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLong1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLong2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLong3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLong4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLong5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereMedidaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereModificadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereModificadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereNombreCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereNombreCortoOrdenSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereNombreMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereNumExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereNumInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereOficioEnvio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereOrdenImageMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereOrigenHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereOrigenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas wherePrioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas wherePrioridadHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas wherePrioridadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereSearchGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereSearchGoogleSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereSearchtextCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereSearchtextdenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereServicioHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereServicioUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereStatusDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereSubarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereSubareaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereSubareaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereSueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereTelefonos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereTelefonoscelularesemails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereUbicacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereUeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereUltimoEstatusResuelto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSS_Viejitas whereUuid($value)
 */
	class _viDDSS_Viejitas extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\_viDDSs
 *
 * @property int|null $id
 * @property string|null $fecha_ingreso
 * @property string|null $cantidad
 * @property string|null $denuncia
 * @property string|null $referencia
 * @property string|null $oficio_envio
 * @property string|null $fecha_oficio_dependencia
 * @property string|null $fecha_limite
 * @property string|null $fecha_ejecucion
 * @property string|null $calle
 * @property string|null $num_ext
 * @property string|null $num_int
 * @property string|null $colonia
 * @property string|null $comunidad
 * @property string|null $cp
 * @property \App\Models\Catalogos\Domicilios\Ubicacion|null $ubicacion
 * @property string|null $search_google
 * @property string|null $gd_ubicacion
 * @property string|null $gd_searchtext
 * @property string|null $calle_y_numero_searchtext
 * @property float|null $latitud
 * @property float|null $longitud
 * @property string|null $lati1
 * @property string|null $long1
 * @property string|null $lati2
 * @property string|null $long2
 * @property string|null $lati3
 * @property string|null $long3
 * @property string|null $lati4
 * @property string|null $long4
 * @property string|null $lati5
 * @property string|null $long5
 * @property float|null $altitud
 * @property int|null $ubicacion_id
 * @property int|null $estatus_id
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $estatus
 * @property int|null $estatus_resuelto
 * @property int|null $estatus_habilitado
 * @property int|null $ambito_estatus
 * @property int|null $status_denuncia
 * @property int|null $prioridad_id
 * @property \App\Models\Catalogos\Prioridad|null $prioridad
 * @property int|null $prioridad_habilitada
 * @property int|null $origen_id
 * @property \App\Models\Catalogos\Origen|null $origen
 * @property int|null $origen_habilitado
 * @property int|null $servicio_id
 * @property \App\Models\Catalogos\Servicio|null $servicio
 * @property bool|null $habilitado
 * @property int|null $medida_id
 * @property int|null $subarea_id
 * @property string|null $subarea
 * @property int|null $subarea_habilitada
 * @property int|null $area_id
 * @property string|null $area
 * @property int|null $area_habilitada
 * @property int|null $dependencia_id
 * @property \App\Models\Catalogos\Dependencia|null $dependencia
 * @property string|null $abreviatura
 * @property int|null $ambito_dependencia
 * @property int|null $dependencia_habilitada
 * @property int|null $ciudadano_id
 * @property string|null $username
 * @property string|null $ap_paterno_ciudadano
 * @property string|null $ap_materno_ciudadano
 * @property string|null $nombre_ciudadano
 * @property \App\User|null $ciudadano
 * @property int|null $genero
 * @property string|null $genero_ciudadano
 * @property int|null $creadopor_id
 * @property \App\User|null $creadopor
 * @property string|null $curp_creadopor
 * @property int|null $modificadopor_id
 * @property \App\User|null $modificadopor
 * @property string|null $curp_modificadopor
 * @property string|null $celulares
 * @property string|null $telefonos
 * @property string|null $email
 * @property string|null $telefonoscelularesemails
 * @property string|null $curp_ciudadano
 * @property string|null $searchtext_ciudadano
 * @property string|null $domicilio_ciudadano_internet
 * @property string|null $observaciones
 * @property bool|null $cerrado
 * @property string|null $fecha_cerrado
 * @property int|null $cerradopor_id
 * @property \App\User|null $cerradopor
 * @property string|null $curp_cerradopor
 * @property bool|null $firmado
 * @property string|null $uuid
 * @property string|null $folio_sas
 * @property bool|null $favorable
 * @property string|null $clave_identificadora
 * @property int|null $denunciamobile_id
 * @property int|null $ambito
 * @property string|null $ambito_sas
 * @property int|null $servicio_habilitado
 * @property string|null $ambito_servicio
 * @property string|null $estatus_general
 * @property int|null $ue_id
 * @property int|null $ambito_ultimo_estatus
 * @property \App\Models\Catalogos\Estatu|null $ultimo_estatus
 * @property string|null $fecha_ultimo_estatus
 * @property int|null $ultimo_estatus_resuelto
 * @property int|null $due_id
 * @property \App\Models\Catalogos\Dependencia|null $dependencia_ultimo_estatus
 * @property int|null $sue_id
 * @property \App\Models\Catalogos\Servicio|null $servicio_ultimo_estatus
 * @property string|null $searchtextdenuncia
 * @property bool|null $is_visible_mobile
 * @property string|null $nombre_mobile
 * @property int|null $orden_image_mobile
 * @property string|null $nombre_corto_ss
 * @property int|null $nombre_corto_orden_ss
 * @property bool|null $is_visible_nombre_corto_ss
 * @property int|null $dias_ejecucion
 * @property int|null $dias_maximos_ejecucion
 * @property string|null $fecha_dias_ejecucion
 * @property string|null $fecha_dias_maximos_ejecucion
 * @property int|null $centro_localidad_id
 * @property int|null $dias_atendida
 * @property int|null $dias_rechazada
 * @property int|null $dias_observada
 * @property string|null $codigo_postal_manual
 * @property string|null $search_google_select
 * @property string|null $centro_colonia
 * @property string|null $centro_delegacion
 * @property int|null $delegado_id
 * @property string|null $delegado
 * @property string|null $zona
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $ciudadanos
 * @property-read int|null $ciudadanos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $creadospor
 * @property-read int|null $creadospor_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $denuncia_dependencias
 * @property-read int|null $denuncia_dependencias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $denuncia_estatus
 * @property-read int|null $denuncia_estatus_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $denuncia_servicios
 * @property-read int|null $denuncia_servicios_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $dependencias
 * @property-read int|null $dependencias_count
 * @property-read \App\Models\Catalogos\Estatu|null $estatu
 * @property-read int|null $estatus_count
 * @property-read \App\Models\Denuncias\Firma|null $firma
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Firma[] $firmas
 * @property-read int|null $firmas_count
 * @property-read mixed $fecha_ingreso_solicitud
 * @property-read mixed $folio_dac
 * @property-read mixed $full_ubication
 * @property-read mixed $total_respuestas
 * @property-read mixed $ultima_dependencia
 * @property-read mixed $ultima_fecha_estatus
 * @property-read mixed $ultima_respuesta
 * @property-read mixed $ultimo_servicio
 * @property-read mixed $ultimos_estatus
 * @property-read \App\Models\Denuncias\Imagene|null $imagene
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Imagene[] $imagenes
 * @property-read int|null $imagenes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $modificadospor
 * @property-read int|null $modificadospor_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Origen[] $origenes
 * @property-read int|null $origenes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Prioridad[] $prioridades
 * @property-read int|null $prioridades_count
 * @property-read \App\Models\Denuncias\Respuesta|null $respuesta
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Respuesta[] $respuestas
 * @property-read int|null $respuestas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $servicios
 * @property-read int|null $servicios_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Ubicacion[] $ubicaciones
 * @property-read int|null $ubicaciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia_Dependencia_Servicio[] $ultimo_estatu_denuncia_dependencia_servicio
 * @property-read int|null $ultimo_estatu_denuncia_dependencia_servicio_count
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs ambitoFilterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs filterByCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs getDenunciasAmbitoFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs getDenunciasAmbitoItemCustomFilter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs getDenunciasEstatusAmbitoFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs getDenunciasItemCustomFilter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs query()
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereAltitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereAmbito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereAmbitoDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereAmbitoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereAmbitoSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereAmbitoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereAmbitoUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereApMaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereApPaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereAreaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCalleYNumeroSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCelulares($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCentroColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCentroDelegacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCentroLocalidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCerrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCerradopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCerradoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCiudadanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereClaveIdentificadora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCodigoPostalManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCreadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCreadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCurpCerradopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCurpCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCurpCreadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereCurpModificadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDelegado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDelegadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDenunciamobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDependenciaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDependenciaUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDiasAtendida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDiasObservada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDiasRechazada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDomicilioCiudadanoInternet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereDueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereEstatusGeneral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereEstatusHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereEstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereEstatusResuelto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereFavorable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereFechaCerrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereFechaDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereFechaDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereFechaEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereFechaIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereFechaLimite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereFechaOficioDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereFechaUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereFirmado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereFolioSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereGdSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereGdUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereGenero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereGeneroCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereIsVisibleMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereIsVisibleNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLati1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLati2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLati3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLati4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLati5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLong1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLong2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLong3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLong4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLong5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereMedidaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereModificadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereModificadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereNombreCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereNombreCortoOrdenSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereNombreMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereNumExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereNumInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereOficioEnvio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereOrdenImageMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereOrigenHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereOrigenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs wherePrioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs wherePrioridadHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs wherePrioridadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereSearchGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereSearchGoogleSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereSearchtextCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereSearchtextdenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereServicioHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereServicioUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereStatusDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereSubarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereSubareaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereSubareaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereSueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereTelefonos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereTelefonoscelularesemails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereUbicacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereUeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereUltimoEstatusResuelto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDDSs whereZona($value)
 */
	class _viDDSs extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\_viDepDenServEstatus
 *
 * @property int|null $ddse_id
 * @property int|null $id
 * @property string|null $fecha_ingreso
 * @property string|null $descripcion
 * @property string|null $referencia
 * @property string|null $fecha_limite
 * @property string|null $fecha_ejecucion
 * @property string|null $calle
 * @property string|null $num_ext
 * @property string|null $num_int
 * @property string|null $colonia
 * @property string|null $comunidad
 * @property string|null $cp
 * @property string|null $ubicacion_solicitud
 * @property string|null $search_google
 * @property string|null $gd_ubicacion
 * @property string|null $gd_searchtext
 * @property string|null $calle_y_numero_searchtext
 * @property float|null $latitud
 * @property float|null $longitud
 * @property string|null $lati1
 * @property string|null $long1
 * @property string|null $lati2
 * @property string|null $long2
 * @property string|null $lati3
 * @property string|null $long3
 * @property string|null $lati4
 * @property string|null $long4
 * @property string|null $lati5
 * @property string|null $long5
 * @property int|null $ubicacion_id
 * @property int|null $estatu_id
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $estatus
 * @property int|null $estatus_resuelto
 * @property int|null $estatus_habilitado
 * @property int|null $ambito_estatus
 * @property int|null $status_denuncia
 * @property int|null $prioridad_id
 * @property \App\Models\Catalogos\Prioridad|null $prioridad
 * @property int|null $prioridad_habilitada
 * @property int|null $origen_id
 * @property \App\Models\Catalogos\Origen|null $origen
 * @property int|null $origen_habilitado
 * @property int|null $servicio_id
 * @property string|null $servicio
 * @property bool|null $habilitado
 * @property int|null $medida_id
 * @property int|null $subarea_id
 * @property string|null $subarea
 * @property int|null $subarea_habilitada
 * @property int|null $area_id
 * @property string|null $area
 * @property int|null $area_habilitada
 * @property int|null $dependencia_id
 * @property string|null $dependencia
 * @property string|null $abreviatura
 * @property int|null $ambito_dependencia
 * @property int|null $dependencia_habilitada
 * @property int|null $ciudadano_id
 * @property string|null $ap_paterno_ciudadano
 * @property string|null $ap_materno_ciudadano
 * @property string|null $nombre_ciudadano
 * @property string|null $ciudadano
 * @property int|null $genero
 * @property string|null $genero_ciudadano
 * @property int|null $creadopor_id
 * @property \App\User|null $creadopor
 * @property string|null $curp_creadopor
 * @property int|null $modificadopor_id
 * @property \App\User|null $modificadopor
 * @property string|null $curp_modificadopor
 * @property string|null $telefonoscelularesemails
 * @property string|null $email
 * @property string|null $curp_ciudadano
 * @property string|null $username_ciudadano
 * @property string|null $observaciones_denuncia
 * @property bool|null $cerrado
 * @property string|null $fecha_cerrado
 * @property int|null $cerradopor_id
 * @property \App\User|null $cerradopor
 * @property string|null $curp_cerradopor
 * @property bool|null $firmado
 * @property string|null $uuid
 * @property string|null $folio_sas
 * @property bool|null $denuncia_favorable
 * @property string|null $clave_identificadora
 * @property int|null $denunciamobile_id
 * @property int|null $ambito
 * @property string|null $ambito_sas
 * @property int|null $servicio_habilitado
 * @property string|null $ambito_servicio
 * @property int|null $ue_id
 * @property string|null $fecha_ultimo_estatus
 * @property int|null $due_id
 * @property int|null $sue_id
 * @property string|null $searchtextdenuncia
 * @property bool|null $is_visible_mobile
 * @property int|null $dias_ejecucion
 * @property int|null $dias_maximos_ejecucion
 * @property string|null $fecha_dias_ejecucion
 * @property string|null $fecha_dias_maximos_ejecucion
 * @property int|null $centro_localidad_id
 * @property string|null $centro_colonia
 * @property string|null $centro_delegacion
 * @property int|null $delegado_id
 * @property string|null $delegado
 * @property int|null $dias_atendida
 * @property int|null $dias_rechazada
 * @property int|null $dias_observada
 * @property string|null $observaciones
 * @property string|null $fecha_movimiento
 * @property bool|null $favorable
 * @property bool|null $fue_leida
 * @property int|null $creadopor_id_ue
 * @property string|null $usuario_ultimo_estatus
 * @property string|null $codigo_postal_manual
 * @property string|null $search_google_select
 * @property int|null $totalrespuestas_solicitud
 * @property string|null $zona
 * @property-read \App\Models\Catalogos\Servicio|null $Servicio
 * @property-read \App\User|null $ciudadano_simple
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $ciudadanos
 * @property-read int|null $ciudadanos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $creadospor
 * @property-read int|null $creadospor_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $denuncia_dependencias
 * @property-read int|null $denuncia_dependencias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $denuncia_estatus
 * @property-read int|null $denuncia_estatus_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $denuncia_servicios
 * @property-read int|null $denuncia_servicios_count
 * @property-read \App\Models\Catalogos\Dependencia|null $dependencia_simple
 * @property-read \App\Models\Catalogos\Dependencia|null $dependencia_ultimo_estatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $dependencias
 * @property-read int|null $dependencias_count
 * @property-read \App\Models\Catalogos\Estatu|null $estatu
 * @property-read int|null $estatus_count
 * @property-read \App\Models\Denuncias\Firma|null $firma
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Firma[] $firmas
 * @property-read int|null $firmas_count
 * @property-read mixed $fecha_ingreso_solicitud
 * @property-read mixed $folio_dac
 * @property-read mixed $full_ubication
 * @property-read mixed $total_respuestas
 * @property-read mixed $ultima_dependencia
 * @property-read mixed $ultima_fecha_estatus
 * @property-read mixed $ultima_respuesta
 * @property-read mixed $ultimo_servicio
 * @property-read mixed $ultimos_estatus
 * @property-read \App\Models\Denuncias\Imagene|null $imagene
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Imagene[] $imagenes
 * @property-read int|null $imagenes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $modificadospor
 * @property-read int|null $modificadospor_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Origen[] $origenes
 * @property-read int|null $origenes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Prioridad[] $prioridades
 * @property-read int|null $prioridades_count
 * @property-read \App\Models\Denuncias\Respuesta|null $respuesta
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Respuesta[] $respuestas
 * @property-read int|null $respuestas_count
 * @property-read \App\Models\Catalogos\Servicio|null $servicio_ultimo_estatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $servicios
 * @property-read int|null $servicios_count
 * @property-read \App\Models\Catalogos\Domicilios\Ubicacion|null $ubicacion
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Ubicacion[] $ubicaciones
 * @property-read int|null $ubicaciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia_Dependencia_Servicio[] $ultimo_estatu_denuncia_dependencia_servicio
 * @property-read int|null $ultimo_estatu_denuncia_dependencia_servicio_count
 * @property-read \App\Models\Catalogos\Estatu|null $ultimo_estatus
 * @property-read \App\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus ambitoFilterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus filterByCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus getDenunciasAmbitoFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus getDenunciasAmbitoItemCustomFilter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus getDenunciasEstatusAmbitoFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus getDenunciasItemCustomFilter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus latestStatusByDependencias(?array $dependencias = null)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereAmbito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereAmbitoDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereAmbitoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereAmbitoSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereAmbitoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereApMaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereApPaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereAreaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCalleYNumeroSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCentroColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCentroDelegacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCentroLocalidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCerrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCerradopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCerradoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCiudadanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereClaveIdentificadora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCodigoPostalManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCreadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCreadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCreadoporIdUe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCurpCerradopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCurpCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCurpCreadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereCurpModificadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDdseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDelegado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDelegadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDenunciaFavorable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDenunciamobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDependenciaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDiasAtendida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDiasObservada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDiasRechazada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereDueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereEstatuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereEstatusHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereEstatusResuelto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFavorable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFechaCerrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFechaDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFechaDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFechaEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFechaIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFechaLimite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFechaMovimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFechaUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFirmado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFolioSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereFueLeida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereGdSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereGdUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereGenero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereGeneroCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereIsVisibleMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLati1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLati2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLati3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLati4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLati5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLong1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLong2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLong3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLong4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLong5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereMedidaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereModificadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereModificadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereNombreCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereNumExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereNumInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereObservacionesDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereOrigenHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereOrigenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus wherePrioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus wherePrioridadHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus wherePrioridadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereSearchGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereSearchGoogleSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereSearchtextdenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereServicioHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereStatusDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereSubarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereSubareaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereSubareaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereSueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereTelefonoscelularesemails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereTotalrespuestasSolicitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereUbicacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereUbicacionSolicitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereUeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereUsernameCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereUsuarioUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viDepDenServEstatus whereZona($value)
 */
	class _viDepDenServEstatus extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\_viMovSASSM
 *
 * @property int|null $id
 * @property int|null $denuncia_id
 * @property string|null $fecha_ingreso
 * @property string|null $descripcion
 * @property string|null $referencia
 * @property string|null $fecha_limite
 * @property string|null $fecha_ejecucion
 * @property string|null $calle
 * @property string|null $num_ext
 * @property string|null $num_int
 * @property string|null $colonia
 * @property string|null $comunidad
 * @property string|null $cp
 * @property string|null $ubicacion
 * @property string|null $search_google
 * @property string|null $gd_ubicacion
 * @property string|null $gd_searchtext
 * @property string|null $calle_y_numero_searchtext
 * @property float|null $latitud
 * @property float|null $longitud
 * @property int|null $estatu_id
 * @property string|null $estatus
 * @property int|null $estatus_resuelto
 * @property int|null $estatus_habilitado
 * @property int|null $ambito_estatus
 * @property int|null $status_denuncia
 * @property int|null $prioridad_id
 * @property string|null $prioridad
 * @property int|null $prioridad_habilitada
 * @property int|null $origen_id
 * @property string|null $origen
 * @property int|null $origen_habilitado
 * @property int|null $servicio_id
 * @property string|null $servicio
 * @property int|null $dependencia_id
 * @property string|null $dependencia
 * @property string|null $abreviatura
 * @property int|null $ambito_dependencia
 * @property int|null $dependencia_habilitada
 * @property int|null $ciudadano_id
 * @property string|null $ap_paterno_ciudadano
 * @property string|null $ap_materno_ciudadano
 * @property string|null $nombre_ciudadano
 * @property string|null $ciudadano
 * @property string|null $telefonos_ciudadano
 * @property string|null $email_ciudadano
 * @property string|null $curp_ciudadano
 * @property string|null $username_ciudadano
 * @property int|null $genero
 * @property string|null $genero_ciudadano
 * @property string|null $searchtext_ciudadano
 * @property string|null $uuid
 * @property string|null $folio_sas
 * @property int|null $ambito
 * @property string|null $ambito_sas
 * @property int|null $servicio_habilitado
 * @property string|null $ambito_servicio
 * @property int|null $ue_id
 * @property string|null $fecha_ultimo_estatus
 * @property int|null $due_id
 * @property int|null $sue_id
 * @property string|null $nombre_corto_ss
 * @property int|null $dias_ejecucion
 * @property int|null $dias_maximos_ejecucion
 * @property string|null $fecha_dias_ejecucion
 * @property string|null $fecha_dias_maximos_ejecucion
 * @property int|null $centro_localidad_id
 * @property string|null $centro_colonia
 * @property string|null $centro_delegacion
 * @property int|null $delegado_id
 * @property string|null $delegado
 * @property int|null $dias_atendida
 * @property int|null $dias_rechazada
 * @property int|null $dias_observada
 * @property string|null $observaciones
 * @property string|null $fecha_movimiento
 * @property string|null $codigo_postal_manual
 * @property string|null $search_google_select
 * @property string|null $zona
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM query()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereAmbito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereAmbitoDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereAmbitoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereAmbitoSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereAmbitoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereApMaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereApPaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereCalleYNumeroSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereCentroColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereCentroDelegacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereCentroLocalidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereCiudadanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereCodigoPostalManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereCurpCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDelegado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDelegadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDependenciaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDiasAtendida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDiasObservada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDiasRechazada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereDueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereEmailCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereEstatuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereEstatusHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereEstatusResuelto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereFechaDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereFechaDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereFechaEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereFechaIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereFechaLimite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereFechaMovimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereFechaUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereFolioSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereGdSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereGdUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereGenero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereGeneroCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereNombreCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereNumExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereNumInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereOrigenHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereOrigenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM wherePrioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM wherePrioridadHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM wherePrioridadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereSearchGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereSearchGoogleSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereSearchtextCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereServicioHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereStatusDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereSueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereTelefonosCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereUeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereUsernameCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSASSM whereZona($value)
 */
	class _viMovSASSM extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\_viMovSM
 *
 * @property int|null $id
 * @property int|null $denuncia_id
 * @property string|null $fecha_ingreso
 * @property string|null $descripcion
 * @property string|null $referencia
 * @property string|null $fecha_limite
 * @property string|null $fecha_ejecucion
 * @property string|null $calle
 * @property string|null $num_ext
 * @property string|null $num_int
 * @property string|null $colonia
 * @property string|null $comunidad
 * @property string|null $cp
 * @property string|null $ubicacion
 * @property string|null $search_google
 * @property string|null $gd_ubicacion
 * @property string|null $gd_searchtext
 * @property string|null $calle_y_numero_searchtext
 * @property float|null $latitud
 * @property float|null $longitud
 * @property int|null $estatu_id
 * @property string|null $estatus
 * @property int|null $estatus_resuelto
 * @property int|null $estatus_habilitado
 * @property int|null $ambito_estatus
 * @property int|null $status_denuncia
 * @property int|null $prioridad_id
 * @property string|null $prioridad
 * @property int|null $prioridad_habilitada
 * @property int|null $origen_id
 * @property string|null $origen
 * @property int|null $origen_habilitado
 * @property int|null $servicio_id
 * @property string|null $servicio
 * @property int|null $dependencia_id
 * @property string|null $dependencia
 * @property string|null $abreviatura
 * @property int|null $ambito_dependencia
 * @property int|null $dependencia_habilitada
 * @property int|null $ciudadano_id
 * @property string|null $ap_paterno_ciudadano
 * @property string|null $ap_materno_ciudadano
 * @property string|null $nombre_ciudadano
 * @property string|null $ciudadano
 * @property string|null $telefonos_ciudadano
 * @property string|null $email_ciudadano
 * @property string|null $curp_ciudadano
 * @property string|null $username_ciudadano
 * @property int|null $genero
 * @property string|null $genero_ciudadano
 * @property string|null $searchtext_ciudadano
 * @property string|null $uuid
 * @property string|null $folio_sas
 * @property int|null $ambito
 * @property string|null $ambito_sas
 * @property int|null $servicio_habilitado
 * @property string|null $ambito_servicio
 * @property int|null $ue_id
 * @property string|null $fecha_ultimo_estatus
 * @property int|null $due_id
 * @property int|null $sue_id
 * @property string|null $nombre_corto_ss
 * @property int|null $dias_ejecucion
 * @property int|null $dias_maximos_ejecucion
 * @property string|null $fecha_dias_ejecucion
 * @property string|null $fecha_dias_maximos_ejecucion
 * @property int|null $centro_localidad_id
 * @property string|null $centro_colonia
 * @property string|null $centro_delegacion
 * @property int|null $delegado_id
 * @property string|null $delegado
 * @property int|null $dias_atendida
 * @property int|null $dias_rechazada
 * @property int|null $dias_observada
 * @property string|null $observaciones
 * @property string|null $fecha_movimiento
 * @property string|null $codigo_postal_manual
 * @property string|null $search_google_select
 * @property int|null $creadopor_id
 * @property string|null $zona
 * @property-read mixed $fecha_ingreso_solicitud
 * @property-read mixed $folio_dac
 * @property-read mixed $full_ubication
 * @property-read mixed $total_respuestas
 * @property-read mixed $ultima_dependencia
 * @property-read mixed $ultima_fecha_estatus
 * @property-read mixed $ultima_respuesta
 * @property-read mixed $ultimo_servicio
 * @property-read mixed $ultimos_estatus
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM query()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereAmbito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereAmbitoDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereAmbitoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereAmbitoSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereAmbitoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereApMaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereApPaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereCalleYNumeroSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereCentroColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereCentroDelegacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereCentroLocalidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereCiudadanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereCodigoPostalManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereCreadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereCurpCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDelegado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDelegadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDependenciaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDiasAtendida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDiasObservada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDiasRechazada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereDueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereEmailCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereEstatuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereEstatusHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereEstatusResuelto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereFechaDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereFechaDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereFechaEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereFechaIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereFechaLimite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereFechaMovimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereFechaUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereFolioSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereGdSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereGdUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereGenero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereGeneroCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereNombreCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereNumExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereNumInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereOrigenHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereOrigenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM wherePrioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM wherePrioridadHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM wherePrioridadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereSearchGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereSearchGoogleSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereSearchtextCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereServicioHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereStatusDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereSueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereTelefonosCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereUeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereUsernameCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSM whereZona($value)
 */
	class _viMovSM extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\_viMovSMTodas
 *
 * @property int|null $id
 * @property int|null $denuncia_id
 * @property string|null $fecha_ingreso
 * @property string|null $descripcion
 * @property string|null $referencia
 * @property string|null $fecha_limite
 * @property string|null $fecha_ejecucion
 * @property string|null $calle
 * @property string|null $num_ext
 * @property string|null $num_int
 * @property string|null $colonia
 * @property string|null $comunidad
 * @property string|null $cp
 * @property string|null $ubicacion
 * @property string|null $search_google
 * @property string|null $gd_ubicacion
 * @property string|null $gd_searchtext
 * @property string|null $calle_y_numero_searchtext
 * @property float|null $latitud
 * @property float|null $longitud
 * @property int|null $estatu_id
 * @property string|null $estatus
 * @property int|null $estatus_resuelto
 * @property int|null $estatus_habilitado
 * @property int|null $ambito_estatus
 * @property int|null $status_denuncia
 * @property int|null $prioridad_id
 * @property string|null $prioridad
 * @property int|null $prioridad_habilitada
 * @property int|null $origen_id
 * @property string|null $origen
 * @property int|null $origen_habilitado
 * @property int|null $servicio_id
 * @property string|null $servicio
 * @property int|null $dependencia_id
 * @property string|null $dependencia
 * @property string|null $abreviatura
 * @property int|null $ambito_dependencia
 * @property int|null $dependencia_habilitada
 * @property int|null $ciudadano_id
 * @property string|null $ap_paterno_ciudadano
 * @property string|null $ap_materno_ciudadano
 * @property string|null $nombre_ciudadano
 * @property string|null $ciudadano
 * @property string|null $telefonos_ciudadano
 * @property string|null $email_ciudadano
 * @property string|null $curp_ciudadano
 * @property string|null $username_ciudadano
 * @property int|null $genero
 * @property string|null $genero_ciudadano
 * @property string|null $searchtext_ciudadano
 * @property string|null $uuid
 * @property string|null $folio_sas
 * @property int|null $ambito
 * @property string|null $ambito_sas
 * @property int|null $servicio_habilitado
 * @property string|null $ambito_servicio
 * @property int|null $ue_id
 * @property string|null $fecha_ultimo_estatus
 * @property int|null $due_id
 * @property int|null $sue_id
 * @property string|null $nombre_corto_ss
 * @property int|null $dias_ejecucion
 * @property int|null $dias_maximos_ejecucion
 * @property string|null $fecha_dias_ejecucion
 * @property string|null $fecha_dias_maximos_ejecucion
 * @property int|null $centro_localidad_id
 * @property string|null $centro_colonia
 * @property string|null $centro_delegacion
 * @property int|null $delegado_id
 * @property string|null $delegado
 * @property int|null $dias_atendida
 * @property int|null $dias_rechazada
 * @property int|null $dias_observada
 * @property string|null $observaciones
 * @property string|null $fecha_movimiento
 * @property string|null $codigo_postal_manual
 * @property string|null $search_google_select
 * @property int|null $creadopor_id
 * @property string|null $zona
 * @property-read mixed $fecha_ingreso_solicitud
 * @property-read mixed $folio_dac
 * @property-read mixed $full_ubication
 * @property-read mixed $total_respuestas
 * @property-read mixed $ultima_dependencia
 * @property-read mixed $ultima_fecha_estatus
 * @property-read mixed $ultima_respuesta
 * @property-read mixed $ultimo_servicio
 * @property-read mixed $ultimos_estatus
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas query()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereAmbito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereAmbitoDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereAmbitoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereAmbitoSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereAmbitoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereApMaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereApPaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereCalleYNumeroSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereCentroColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereCentroDelegacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereCentroLocalidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereCiudadanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereCodigoPostalManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereCreadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereCurpCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDelegado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDelegadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDependenciaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDiasAtendida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDiasObservada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDiasRechazada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereDueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereEmailCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereEstatuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereEstatusHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereEstatusResuelto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereFechaDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereFechaDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereFechaEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereFechaIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereFechaLimite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereFechaMovimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereFechaUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereFolioSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereGdSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereGdUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereGenero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereGeneroCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereNombreCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereNumExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereNumInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereOrigenHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereOrigenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas wherePrioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas wherePrioridadHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas wherePrioridadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereSearchGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereSearchGoogleSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereSearchtextCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereServicioHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereStatusDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereSueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereTelefonosCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereUeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereUsernameCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovSMTodas whereZona($value)
 */
	class _viMovSMTodas extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\_viMovimientos
 *
 * @property int|null $id
 * @property int|null $denuncia_id
 * @property string|null $fecha_ingreso
 * @property string|null $cantidad
 * @property string|null $descripcion
 * @property string|null $referencia
 * @property string|null $oficio_envio
 * @property string|null $fecha_oficio_dependencia
 * @property string|null $fecha_limite
 * @property string|null $fecha_ejecucion
 * @property string|null $calle
 * @property string|null $num_ext
 * @property string|null $num_int
 * @property string|null $colonia
 * @property string|null $comunidad
 * @property string|null $cp
 * @property \App\Models\Catalogos\Domicilios\Ubicacion|null $ubicacion
 * @property string|null $search_google
 * @property string|null $gd_ubicacion
 * @property string|null $gd_searchtext
 * @property string|null $calle_y_numero_searchtext
 * @property float|null $latitud
 * @property float|null $longitud
 * @property string|null $lati1
 * @property string|null $long1
 * @property string|null $lati2
 * @property string|null $long2
 * @property string|null $lati3
 * @property string|null $long3
 * @property string|null $lati4
 * @property string|null $long4
 * @property string|null $lati5
 * @property string|null $long5
 * @property float|null $altitud
 * @property int|null $ubicacion_id
 * @property int|null $estatu_id
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $estatus
 * @property int|null $estatus_resuelto
 * @property int|null $estatus_habilitado
 * @property int|null $ambito_estatus
 * @property int|null $status_denuncia
 * @property int|null $prioridad_id
 * @property \App\Models\Catalogos\Prioridad|null $prioridad
 * @property int|null $prioridad_habilitada
 * @property int|null $origen_id
 * @property \App\Models\Catalogos\Origen|null $origen
 * @property int|null $origen_habilitado
 * @property int|null $servicio_id
 * @property \App\Models\Catalogos\Servicio|null $servicio
 * @property bool|null $habilitado
 * @property int|null $medida_id
 * @property int|null $subarea_id
 * @property string|null $subarea
 * @property int|null $subarea_habilitada
 * @property int|null $area_id
 * @property string|null $area
 * @property int|null $area_habilitada
 * @property int|null $dependencia_id
 * @property \App\Models\Catalogos\Dependencia|null $dependencia
 * @property string|null $abreviatura
 * @property int|null $ambito_dependencia
 * @property int|null $dependencia_habilitada
 * @property int|null $ciudadano_id
 * @property string|null $ap_paterno_ciudadano
 * @property string|null $ap_materno_ciudadano
 * @property string|null $nombre_ciudadano
 * @property \App\User|null $ciudadano
 * @property int|null $genero
 * @property string|null $genero_ciudadano
 * @property int|null $creadopor_id
 * @property \App\User|null $creadopor
 * @property string|null $curp_creadopor
 * @property int|null $modificadopor_id
 * @property \App\User|null $modificadopor
 * @property string|null $curp_modificadopor
 * @property string|null $telefonoscelularesemails
 * @property string|null $email
 * @property string|null $curp_ciudadano
 * @property string|null $username_ciudadano
 * @property string|null $searchtext_ciudadano
 * @property string|null $domicilio_ciudadano_internet
 * @property string|null $observaciones_denuncia
 * @property bool|null $cerrado
 * @property string|null $fecha_cerrado
 * @property int|null $cerradopor_id
 * @property \App\User|null $cerradopor
 * @property string|null $curp_cerradopor
 * @property bool|null $firmado
 * @property string|null $uuid
 * @property string|null $folio_sas
 * @property bool|null $denuncia_favorable
 * @property string|null $clave_identificadora
 * @property int|null $denunciamobile_id
 * @property int|null $ambito
 * @property string|null $ambito_sas
 * @property int|null $servicio_habilitado
 * @property string|null $ambito_servicio
 * @property string|null $estatus_general
 * @property int|null $ue_id
 * @property string|null $fecha_ultimo_estatus
 * @property int|null $due_id
 * @property int|null $sue_id
 * @property string|null $searchtextdenuncia
 * @property bool|null $is_visible_mobile
 * @property string|null $nombre_mobile
 * @property int|null $orden_image_mobile
 * @property string|null $nombre_corto_ss
 * @property int|null $nombre_corto_orden_ss
 * @property bool|null $is_visible_nombre_corto_ss
 * @property int|null $dias_ejecucion
 * @property int|null $dias_maximos_ejecucion
 * @property string|null $fecha_dias_ejecucion
 * @property string|null $fecha_dias_maximos_ejecucion
 * @property int|null $centro_localidad_id
 * @property int|null $dias_atendida
 * @property int|null $dias_rechazada
 * @property int|null $dias_observada
 * @property string|null $observaciones
 * @property string|null $fecha_movimiento
 * @property bool|null $favorable
 * @property bool|null $fue_leida
 * @property string|null $codigo_postal_manual
 * @property string|null $search_google_select
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $ciudadanos
 * @property-read int|null $ciudadanos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $creadospor
 * @property-read int|null $creadospor_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $denuncia_dependencias
 * @property-read int|null $denuncia_dependencias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $denuncia_estatus
 * @property-read int|null $denuncia_estatus_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $denuncia_servicios
 * @property-read int|null $denuncia_servicios_count
 * @property-read \App\Models\Catalogos\Dependencia|null $dependencia_ultimo_estatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $dependencias
 * @property-read int|null $dependencias_count
 * @property-read \App\Models\Catalogos\Estatu|null $estatu
 * @property-read int|null $estatus_count
 * @property-read \App\Models\Denuncias\Firma|null $firma
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Firma[] $firmas
 * @property-read int|null $firmas_count
 * @property-read mixed $fecha_ingreso_solicitud
 * @property-read mixed $folio_dac
 * @property-read mixed $full_ubication
 * @property-read mixed $total_respuestas
 * @property-read mixed $ultima_dependencia
 * @property-read mixed $ultima_fecha_estatus
 * @property-read mixed $ultima_respuesta
 * @property-read mixed $ultimo_servicio
 * @property-read mixed $ultimos_estatus
 * @property-read \App\Models\Denuncias\Imagene|null $imagene
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Imagene[] $imagenes
 * @property-read int|null $imagenes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $modificadospor
 * @property-read int|null $modificadospor_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Origen[] $origenes
 * @property-read int|null $origenes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Prioridad[] $prioridades
 * @property-read int|null $prioridades_count
 * @property-read \App\Models\Denuncias\Respuesta|null $respuesta
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Respuesta[] $respuestas
 * @property-read int|null $respuestas_count
 * @property-read \App\Models\Catalogos\Servicio|null $servicio_ultimo_estatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $servicios
 * @property-read int|null $servicios_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Ubicacion[] $ubicaciones
 * @property-read int|null $ubicaciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia_Dependencia_Servicio[] $ultimo_estatu_denuncia_dependencia_servicio
 * @property-read int|null $ultimo_estatu_denuncia_dependencia_servicio_count
 * @property-read \App\Models\Catalogos\Estatu|null $ultimo_estatus
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos ambitoFilterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos filterByCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos getDenunciasAmbitoFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos getDenunciasAmbitoItemCustomFilter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos getDenunciasEstatusAmbitoFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos getDenunciasItemCustomFilter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos query()
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereAltitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereAmbito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereAmbitoDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereAmbitoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereAmbitoSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereAmbitoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereApMaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereApPaternoCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereAreaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCalleYNumeroSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCentroLocalidadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCerrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCerradopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCerradoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCiudadanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereClaveIdentificadora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCodigoPostalManual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereComunidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCreadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCreadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCurpCerradopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCurpCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCurpCreadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereCurpModificadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDenunciaFavorable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDenunciamobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDependenciaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDiasAtendida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDiasObservada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDiasRechazada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDomicilioCiudadanoInternet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereDueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereEstatuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereEstatusGeneral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereEstatusHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereEstatusResuelto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFavorable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFechaCerrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFechaDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFechaDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFechaEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFechaIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFechaLimite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFechaMovimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFechaOficioDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFechaUltimoEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFirmado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFolioSas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereFueLeida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereGdSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereGdUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereGenero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereGeneroCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereIsVisibleMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereIsVisibleNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLati1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLati2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLati3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLati4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLati5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLong1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLong2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLong3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLong4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLong5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereMedidaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereModificadopor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereModificadoporId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereNombreCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereNombreCortoOrdenSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereNombreMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereNumExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereNumInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereObservacionesDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereOficioEnvio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereOrdenImageMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereOrigenHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereOrigenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos wherePrioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos wherePrioridadHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos wherePrioridadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereSearchGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereSearchGoogleSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereSearchtextCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereSearchtextdenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereServicioHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereStatusDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereSubarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereSubareaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereSubareaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereSueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereTelefonoscelularesemails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereUbicacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereUeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereUsernameCiudadano($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viMovimientos whereUuid($value)
 */
	class _viMovimientos extends \Eloquent {}
}

namespace App\Models\Denuncias{
/**
 * App\Models\Denuncias\_viServicios
 *
 * @property int|null $id
 * @property string|null $servicio
 * @property bool|null $habilitado
 * @property int|null $medida_id
 * @property string|null $medida
 * @property int|null $subarea_id
 * @property string|null $subarea
 * @property string|null $abreviatura_subarea
 * @property string|null $jefe_subarea
 * @property int|null $area_id
 * @property int|null $subarea_habilitada
 * @property string|null $area
 * @property string|null $abreviatura_area
 * @property string|null $jefe_area
 * @property int|null $dependencia_id
 * @property int|null $area_habilitada
 * @property string|null $dependencia
 * @property string|null $abreviatura_dependencia
 * @property int|null $ambito_dependencia
 * @property string|null $ambito_dependencia_descripcion
 * @property int|null $dependencia_habilitada
 * @property string|null $jefe_dependencia
 * @property string|null $ambito_servicio
 * @property int|null $orden_impresion
 * @property int|null $servicio_habilitado
 * @property bool|null $is_visible_mobile
 * @property string|null $nombre_mobile
 * @property int|null $orden_image_mobile
 * @property string|null $nombre_corto_ss
 * @property int|null $nombre_corto_orden_ss
 * @property bool|null $is_visible_nombre_corto_ss
 * @property int|null $dias_ejecucion
 * @property int|null $dias_maximos_ejecucion
 * @property float|null $promedio_dias_atendida
 * @property float|null $promedio_dias_rechazada
 * @property float|null $promedio_dias_observada
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia[] $denuncias
 * @property-read int|null $denuncias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $dependencias
 * @property-read int|null $dependencias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $estatus
 * @property-read int|null $estatus_count
 * @property-read mixed $path_image
 * @property-read mixed $path_image_thumb
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios query()
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereAbreviaturaArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereAbreviaturaDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereAbreviaturaSubarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereAmbitoDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereAmbitoDependenciaDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereAmbitoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereAreaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereDependenciaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereDiasEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereDiasMaximosEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereIsVisibleMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereIsVisibleNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereJefeArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereJefeDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereJefeSubarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereMedida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereMedidaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereNombreCortoOrdenSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereNombreCortoSs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereNombreMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereOrdenImageMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereOrdenImpresion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios wherePromedioDiasAtendida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios wherePromedioDiasObservada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios wherePromedioDiasRechazada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereServicioHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereSubarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereSubareaHabilitada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|_viServicios whereSubareaId($value)
 */
	class _viServicios extends \Eloquent {}
}

namespace App\Models\Mobiles{
/**
 * App\Models\Mobiles\Denunciamobile
 *
 * @property int $id
 * @property string $denuncia
 * @property string|null $fecha
 * @property string $tipo_mobile
 * @property string $marca_mobile
 * @property int $serviciomobile_id
 * @property int $ubicacion_id
 * @property string|null $ubicacion
 * @property string|null $ubicacion_google
 * @property int $user_id
 * @property float $latitud
 * @property float $longitud
 * @property float $altitud
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $searchtextubicacion
 * @property int|null $denuncia_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $dependencia_id
 * @property int|null $servicio_id
 * @property int|null $estatus_id
 * @property int $estatus_cve 0 = Inactivo, 1 = Activo, 2 = Suspendido, 3 = Cancelado
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Mobiles\Imagemobile[] $Imagemobiles
 * @property-read int|null $imagemobiles_count
 * @property-read \App\Models\Mobiles\Serviciomobile|null $Servicio
 * @property-read \App\Models\Catalogos\Domicilios\Ubicacion|null $Ubicacion
 * @property-read \App\User|null $User
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $ciudadanos
 * @property-read int|null $ciudadanos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Mobiles\Respuestamobile[] $respuestas
 * @property-read int|null $respuestas_count
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile getDenunciasFilterCount($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile getDenunciasItemCustomFilter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile newQuery()
 * @method static \Illuminate\Database\Query\Builder|Denunciamobile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereAltitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereDenuncia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereDenunciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereEstatusCve($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereEstatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereMarcaMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereSearchtextubicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereServiciomobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereTipoMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereUbicacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereUbicacionGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereUbicacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Denunciamobile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Denunciamobile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Denunciamobile withoutTrashed()
 */
	class Denunciamobile extends \Eloquent {}
}

namespace App\Models\Mobiles{
/**
 * App\Models\Mobiles\Imagemobile
 *
 * @property int $id
 * @property string|null $fecha
 * @property string|null $root
 * @property string|null $filename
 * @property string|null $filename_png
 * @property string|null $filename_thumb
 * @property string|null $titulo
 * @property string|null $descripcion
 * @property string|null $momento
 * @property int $user_id
 * @property int $denunciamobile_id
 * @property int $parent_id
 * @property float $latitud
 * @property float $longitud
 * @property float $altitud
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mobiles\Denunciamobile|null $Denuncia
 * @property-read \App\User|null $User
 * @property-read Imagemobile|null $child
 * @property-read \Illuminate\Database\Eloquent\Collection|Imagemobile[] $childs
 * @property-read int|null $childs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Mobiles\Denunciamobile[] $denuncias
 * @property-read int|null $denuncias_count
 * @property-read mixed $path_image
 * @property-read mixed $path_image_thumb
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile newQuery()
 * @method static \Illuminate\Database\Query\Builder|Imagemobile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereAltitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereDenunciamobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereFilenamePng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereFilenameThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereLatitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereLongitud($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereMomento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereRoot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Imagemobile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Imagemobile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Imagemobile withoutTrashed()
 */
	class Imagemobile extends \Eloquent {}
}

namespace App\Models\Mobiles{
/**
 * App\Models\Mobiles\Respuestamobile
 *
 * @property int $id
 * @property string|null $fecha
 * @property string|null $respuesta
 * @property string|null $observaciones
 * @property int $user_id
 * @property int $denunciamobile_id
 * @property int $parent_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mobiles\Denunciamobile|null $Denuncia
 * @property-read \App\User|null $User
 * @property-read Respuestamobile|null $child
 * @property-read \Illuminate\Database\Eloquent\Collection|Respuestamobile[] $childs
 * @property-read int|null $childs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Mobiles\Denunciamobile[] $denuncias
 * @property-read int|null $denuncias_count
 * @property-read mixed $path_image
 * @property-read mixed $path_image_thumb
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile newQuery()
 * @method static \Illuminate\Database\Query\Builder|Respuestamobile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile whereDenunciamobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile whereRespuesta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Respuestamobile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Respuestamobile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Respuestamobile withoutTrashed()
 */
	class Respuestamobile extends \Eloquent {}
}

namespace App\Models\Mobiles{
/**
 * App\Models\Mobiles\Serviciomobile
 *
 * @property int $id
 * @property string $servicio
 * @property bool $habilitado
 * @property bool $is_visible_mobile
 * @property string $url_image_mobile
 * @property int $orden_image_mobile
 * @property int $dependencia_id
 * @property int $area_id
 * @property int $subarea_id
 * @property int $servicio_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Catalogos\Dependencia|null $Dependencia
 * @property-read \App\Models\Catalogos\Servicio|null $Servicio
 * @property-read \App\Models\Catalogos\Area|null $area
 * @property-read mixed $path_image
 * @property-read mixed $path_image_thumb
 * @property-read \App\Models\Catalogos\Subarea|null $subarea
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile newQuery()
 * @method static \Illuminate\Database\Query\Builder|Serviciomobile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile query()
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereDependenciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereHabilitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereIsVisibleMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereOrdenImageMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereServicioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereSubareaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Serviciomobile whereUrlImageMobile($value)
 * @method static \Illuminate\Database\Query\Builder|Serviciomobile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Serviciomobile withoutTrashed()
 */
	class Serviciomobile extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\Categoria
 *
 * @property int $id
 * @property string|null $categoria
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria newQuery()
 * @method static \Illuminate\Database\Query\Builder|Categoria onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereCategoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Categoria whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Categoria withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Categoria withoutTrashed()
 */
	class Categoria extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\UserAdress
 *
 * @property int $id
 * @property string|null $calle
 * @property string|null $num_ext
 * @property string|null $num_int
 * @property string|null $colonia
 * @property string|null $localidad
 * @property string|null $municipio
 * @property string|null $estado
 * @property string|null $pais
 * @property string|null $cp
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserAdress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereCalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereColonia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereCp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereLocalidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereMunicipio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereNumExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereNumInt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress wherePais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAdress whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserAdress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserAdress withoutTrashed()
 */
	class UserAdress extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\UserDataExtend
 *
 * @property int $id
 * @property string|null $ocupacion
 * @property string|null $profesion
 * @property string|null $lugar_trabajo
 * @property string|null $lugar_nacimiento
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserDataExtend onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend whereLugarNacimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend whereLugarTrabajo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend whereOcupacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend whereProfesion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataExtend whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserDataExtend withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserDataExtend withoutTrashed()
 */
	class UserDataExtend extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\UserMobile
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $mobile_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property bool $enabled
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobile newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserMobile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobile query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobile whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobile whereMobileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobile whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|UserMobile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserMobile withoutTrashed()
 */
	class UserMobile extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\UserMobileMessage
 *
 * @property int $id
 * @property int $usermobile_id
 * @property int $user_id
 * @property string $campania
 * @property string $title
 * @property string $message
 * @property string $fecha
 * @property bool $is_read
 * @property string $tags
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\UserMobile[] $MobileDevices
 * @property-read int|null $mobile_devices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserMobileMessage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereCampania($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessage whereUsermobileId($value)
 * @method static \Illuminate\Database\Query\Builder|UserMobileMessage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserMobileMessage withoutTrashed()
 */
	class UserMobileMessage extends \Eloquent {}
}

namespace App\Models\Users{
/**
 * App\Models\Users\UserMobileMessageRequest
 *
 * @property int $id
 * @property int $usermobile_id
 * @property int $usermobilemessage_id
 * @property int $user_id
 * @property string $multicast_id
 * @property int $success
 * @property int $failure
 * @property int $canonical_ids
 * @property string $message_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\UserMobileMessage[] $MobileDeviceMessage
 * @property-read int|null $mobile_device_message_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\UserMobile[] $MobileDevices
 * @property-read int|null $mobile_devices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserMobileMessageRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereCanonicalIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereFailure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereMulticastId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereSuccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereUsermobileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserMobileMessageRequest whereUsermobilemessageId($value)
 * @method static \Illuminate\Database\Query\Builder|UserMobileMessageRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserMobileMessageRequest withoutTrashed()
 */
	class UserMobileMessageRequest extends \Eloquent {}
}

namespace App{
/**
 * App\Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $descripcion
 * @property string|null $color
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Illuminate\Foundation\Auth\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Query\Builder|Permission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Permission withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Permission withoutTrashed()
 */
	class Permission extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $descripcion
 * @property string|null $color
 * @property string|null $abreviatura
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Illuminate\Foundation\Auth\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Query\Builder|Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereAbreviatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Role withoutTrashed()
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $nombre
 * @property string|null $ap_paterno
 * @property string|null $ap_materno
 * @property string|null $curp
 * @property string|null $emails
 * @property string|null $celulares
 * @property string|null $telefonos
 * @property string|null $fecha_nacimiento
 * @property int|null $genero
 * @property string|null $root
 * @property string|null $filename
 * @property string|null $filename_png
 * @property string|null $filename_thumb
 * @property bool $admin
 * @property bool $alumno
 * @property bool $delegado
 * @property string|null $session_id
 * @property int|null $status_user
 * @property int|null $empresa_id
 * @property string|null $ip
 * @property string|null $host
 * @property bool $logged
 * @property string|null $logged_at
 * @property string|null $logout_at
 * @property string|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_mig_id
 * @property string|null $searchtext
 * @property int $ubicacion_id
 * @property int $imagen_id
 * @property string $uuid
 * @property-read \App\Models\Denuncias\Denuncia|null $Denuncia
 * @property-read \App\Models\Denuncias\Imagene|null $Imagen
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\UserMobileMessageRequest[] $MobileDeviceMessageRequests
 * @property-read int|null $mobile_device_message_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\UserMobileMessage[] $MobileDeviceMessages
 * @property-read int|null $mobile_device_messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Users\UserMobile[] $MobileDevices
 * @property-read int|null $mobile_devices_count
 * @property-read \App\Models\Catalogos\Domicilios\Ubicacion $Ubicacion
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia[] $denuncias
 * @property-read int|null $denuncias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Dependencia[] $dependencias
 * @property-read int|null $dependencias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Estatu[] $estatus
 * @property-read int|null $estatus_count
 * @property-read mixed $delegados_id_array
 * @property-read mixed $dependencia_abreviatura_array
 * @property-read mixed $dependencia_abreviatura_str_array
 * @property-read mixed $dependencia_array
 * @property-read mixed $dependencia_id_array
 * @property-read mixed $dependencia_id_str_array
 * @property-read mixed $dependencia_name_str_array
 * @property-read mixed $full_name
 * @property-read mixed $full_name_with_username
 * @property-read mixed $full_name_with_username_dependencia
 * @property-read mixed $full_ubication
 * @property-read string $home
 * @property-read mixed $is_enlace_dependencia
 * @property-read mixed $path_image_p_n_g_profile
 * @property-read mixed $path_image_profile
 * @property-read mixed $path_image_thumb_profile
 * @property-read mixed $permision_id_str_array
 * @property-read mixed $permision_name_str_array
 * @property-read mixed $role_id_array
 * @property-read mixed $role_id_str_array
 * @property-read mixed $role_name_str_array
 * @property-read mixed $servicio_id_array
 * @property-read mixed $str_genero
 * @property-read mixed $telefonos_celulares_emails
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Imagene[] $imagenes
 * @property-read int|null $imagenes_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $operadores
 * @property-read int|null $operadores_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Origen[] $origenes
 * @property-read int|null $origenes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permisos
 * @property-read int|null $permisos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Prioridad[] $prioridades
 * @property-read int|null $prioridades_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Respuesta[] $respuestas
 * @property-read int|null $respuestas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Servicio[] $servicios
 * @property-read int|null $servicios_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\ServicioCategoria[] $servicioscategorias
 * @property-read int|null $servicioscategorias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Denuncias\Denuncia[] $solicitudes
 * @property-read int|null $solicitudes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $supervisores
 * @property-read int|null $supervisores_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Catalogos\Domicilios\Ubicacion[] $ubicaciones
 * @property-read int|null $ubicaciones_count
 * @property-read \App\Models\Users\UserAdress|null $user_adress
 * @property-read \App\Models\Users\UserDataExtend|null $user_data_extend
 * @method static \Illuminate\Database\Eloquent\Builder|User filterBy($filters)
 * @method static \Illuminate\Database\Eloquent\Builder|User myID()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role()
 * @method static \Illuminate\Database\Eloquent\Builder|User search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAlumno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApMaterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApPaterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCelulares($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDelegado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmpresaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFechaNacimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFilenamePng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFilenameThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGenero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImagenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLoggedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogoutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSearchtext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatusUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTelefonos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUbicacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserMigId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

