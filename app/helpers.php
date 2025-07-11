<?php
/*
 * Copyright (c) 2025. Realizado por Carlos Hidalgo
 */

use Symfony\Component\HttpFoundation\StreamedResponse;

if (! function_exists('streamCsvResponse')) {
    function streamCsvResponse(callable $callback, string $filename)
    {
        return new StreamedResponse(
            $callback,
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ]
        );
    }
}
