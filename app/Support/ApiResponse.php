<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, string $message = 'OK', int $status = 200, array $meta = []): JsonResponse
    {
        return response()->json(array_filter([
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'meta'    => $meta ?: null,
        ], fn ($v) => $v !== null), $status);
    }

    public static function error(string $message, int $status = 400, mixed $errors = null): JsonResponse
    {
        return response()->json(array_filter([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], fn ($v) => $v !== null), $status);
    }
}