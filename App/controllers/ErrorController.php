<?php

declare(strict_types=1);

namespace App\Controllers;

class ErrorController
{
    public static function randomError(string $errMessage = 'There was an error'): void
    {
        loadView('error', [
            'errMessage' => $errMessage
        ]);
    }

    public static function notFound(): void
    {
        http_response_code(404);

        loadView('error', [
            'errStatus' => '404',
            'errMessage' => 'The page you are looking for does not exist'
        ]);
    }

    public static function accessDenied(): void
    {
        http_response_code(403);

        loadView('error', [
            'errStatus' => '403',
            'errMessage' => 'Access denied!'
        ]);
    }
}
