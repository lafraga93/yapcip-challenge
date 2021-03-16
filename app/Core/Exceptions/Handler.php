<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Common\Helpers\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Throwable;

final class Handler extends ExceptionHandler
{
    use JsonResponseTrait;

    /**
     * @throws Exception
     */
    public function report(Throwable $exception): void
    {
        parent::report($exception);
    }

    /**
     * @param Request $request
     * @throws Throwable
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        return JsonResponseTrait::response($exception->getMessage(), [], $exception->getCode());
    }
}
