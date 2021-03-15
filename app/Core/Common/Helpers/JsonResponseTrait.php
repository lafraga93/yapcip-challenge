<?php

declare(strict_types=1);

namespace App\Core\Common\Helpers;

use Illuminate\Http\JsonResponse;

trait JsonResponseTrait {
    public static function response(string $message = '', array $data = [], int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
