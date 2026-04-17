<?php
/*
 * Copyright (c) 2026. Realizado por Carlos Hidalgo
 */

namespace App\Traits\Denuncia;

use Carbon\Carbon;

trait DDSTrait
{

    public static function validarOrdenCronologicoFechaMovimiento(
        $id,
        $nuevaFecha,
        $denunciaId,
        $dependenciaId,
        $servicioId,
        $permitirIguales = true
    ) {
        $nuevaFecha = Carbon::parse($nuevaFecha);

        /*
        |--------------------------------------------------------------------------
        | CASO 1: NUEVO REGISTRO
        |--------------------------------------------------------------------------
        */
        if (empty($id) || (int)$id === 0) {
            $ultimoRegistro = self::where('denuncia_id', $denunciaId)
                ->where('dependencia_id', $dependenciaId)
                ->where('servicio_id', $servicioId)
                ->orderBy('fecha_movimiento', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            if ($ultimoRegistro) {
                $fechaUltima = Carbon::parse($ultimoRegistro->fecha_movimiento);

                if ($permitirIguales) {
                    if ($nuevaFecha->lt($fechaUltima)) {
                        return [
                            'ok' => false,
                            'message' => 'La fecha del nuevo registro no puede ser menor que la última fecha registrada: ' .
                                $fechaUltima->format('d-m-Y H:i:s')
                        ];
                    }
                } else {
                    if ($nuevaFecha->lte($fechaUltima)) {
                        return [
                            'ok' => false,
                            'message' => 'La fecha del nuevo registro debe ser mayor que la última fecha registrada: ' .
                                $fechaUltima->format('d-m-Y H:i:s')
                        ];
                    }
                }
            }

            return [
                'ok' => true,
                'message' => 'La fecha del nuevo registro es válida.'
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | CASO 2: EDICIÓN
        |--------------------------------------------------------------------------
        */
        $registroActual = self::find($id);

        if (!$registroActual) {
            return [
                'ok' => false,
                'message' => 'No se encontró el registro a validar.'
            ];
        }

        $registros = self::where('denuncia_id', $registroActual->denuncia_id)
            ->where('dependencia_id', $registroActual->dependencia_id)
            ->where('servicio_id', $registroActual->servicio_id)
            ->orderBy('fecha_movimiento', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->values();

        $index = $registros->search(function ($item) use ($id) {
            return (int)$item->id === (int)$id;
        });

        if ($index === false) {
            return [
                'ok' => false,
                'message' => 'No se encontró la posición del registro en la secuencia cronológica.'
            ];
        }

        $superior = $index > 0 ? $registros[$index - 1] : null;
        $inferior = $index < ($registros->count() - 1) ? $registros[$index + 1] : null;

        if ($permitirIguales) {
            if ($superior && $nuevaFecha->gt(Carbon::parse($superior->fecha_movimiento))) {
                return [
                    'ok' => false,
                    'message' => 'La fecha/hora no puede ser mayor que la del registro superior: ' .
                        Carbon::parse($superior->fecha_movimiento)->format('d-m-Y H:i:s')
                ];
            }

            if ($inferior && $nuevaFecha->lt(Carbon::parse($inferior->fecha_movimiento))) {
                return [
                    'ok' => false,
                    'message' => 'La fecha/hora no puede ser menor que la del registro inferior: ' .
                        Carbon::parse($inferior->fecha_movimiento)->format('d-m-Y H:i:s')
                ];
            }
        } else {
            if ($superior && $nuevaFecha->gte(Carbon::parse($superior->fecha_movimiento))) {
                return [
                    'ok' => false,
                    'message' => 'La fecha/hora debe ser menor que la del registro superior: ' .
                        Carbon::parse($superior->fecha_movimiento)->format('d-m-Y H:i:s')
                ];
            }

            if ($inferior && $nuevaFecha->lte(Carbon::parse($inferior->fecha_movimiento))) {
                return [
                    'ok' => false,
                    'message' => 'La fecha/hora debe ser mayor que la del registro inferior: ' .
                        Carbon::parse($inferior->fecha_movimiento)->format('d-m-Y H:i:s')
                ];
            }
        }

        return [
            'ok' => true,
            'message' => 'La fecha mantiene el orden cronológico.'
        ];
    }


}
