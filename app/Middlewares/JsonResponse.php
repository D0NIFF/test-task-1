<?php

namespace App\Middlewares;

class JsonResponse
{
    public static function handle(array|string $request, string|bool $wrap = 'data')
    {
        $response = [];
        if (!$wrap)
            $response = $request;
        else
            $response['data'] = $request;

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public static function error(string $message, string|bool $wrap = 'data')
    {
        $response = [];
        $message = [
            'status' => 'error',
            'message' => $message,
        ];
        if (!$wrap)
            $response = $message;
        else
            $response['data'] = $message;

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}