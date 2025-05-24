<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

namespace App\Models\Denuncias;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

class _viDepDenServEstatus extends Model{

    protected $table = '_videpdenservestatus';
//    protected $fillable = [
//        'denuncia_id',
//        'dependencia_id',
//        'servicio_id',
//        'estatu_id'
//    ];

    public function scopeLatestStatusByDependencias(Builder $query, array $dependencias = null): Builder
    {
        // Obtener dependencias del usuario si no se pasan como parámetro
        $dependencias = $dependencias ?: Auth::user()->DependenciaInArray();

        // Nombre de la tabla del modelo dinámicamente
        $table = $query->getModel()->getTable();

        // Subconsulta: el máximo id por (denuncia, dependencia, servicio)
        $sub = static::selectRaw('MAX(id) AS max_id')
            ->when($dependencias, fn($q) => $q->whereIn('dependencia_id', $dependencias))
            ->groupBy('denuncia_id', 'dependencia_id', 'servicio_id');

        // Join de la subconsulta y retorno del query para que siga encadenable
        return $query->joinSub($sub, 'latest', function ($join) use ($table) {
            $join->on("{$table}.id", '=', 'latest.max_id');
        })
            // opcional: seleccionar explícitamente todos los campos del modelo
            ->select("{$table}.*");
    }

// Sin parámetro: usa dependencias del usuario autenticado
// $registros = _viDepDenServEstatus::latestStatusByDependencias()->get();

// Pasando un arreglo de dependencias concreto
// $depIds    = [1,2,3];
// $registros = _viDepDenServEstatus::latestStatusByDependencias($depIds)->get();








//SELECT DISTINCT ON (denuncia_id, dependencia_id, servicio_id) *
//FROM _videpdenservestatus
//WHERE dependencia_id in (49,50)
//ORDER BY denuncia_id, dependencia_id, servicio_id, id DESC;


}
