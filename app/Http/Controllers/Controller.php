<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class Controller
{
    public const BASE_PATH = '/api';

    public static function successJson(JsonResource $jsonResource, string $message = 'Success'): JsonResource
    {
        return $jsonResource->additional([
            ...$jsonResource->additional,
            'success' => true,
            'status' => 200,
            'message' => $message,
        ]);
    }

    public static function errorJson(string $message, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => $status,
            'message' => $message,
        ], $status);
    }
}
