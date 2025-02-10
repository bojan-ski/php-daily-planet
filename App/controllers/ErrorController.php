<?php

declare(strict_types=1);

namespace App\Controllers;

class ErrorController{
    public static function randomError(string $errMessage = 'There was an error'){
        loadView('error', [
            'errMessage' => $errMessage
        ]);
    }

    public static function notFound(){
        (string) $errMessage = 'The page you are looking for does not exist';

        http_response_code(404);

        loadView('error', [
            'errStatus' => '404',
            'errMessage' => $errMessage
        ]);
    }

    public static function accessDenied(){
        (string) $errMessage = 'Access denied!';

        http_response_code(403);

        loadView('error', [
            'errStatus' => '403',
            'errMessage' => $errMessage
        ]);
    }
}