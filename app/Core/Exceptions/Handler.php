<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Common\Helpers\JsonResponseTrait;
use Illuminate\Http\{JsonResponse, Request};
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;

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
        $statusCode = $exception->getCode() !== 0 ? $exception->getCode() : 500;
        $message = $statusCode !== 0 ? $exception->getMessage() : 'Não foi possível processar a requisição.';

        return JsonResponseTrait::response($message, [], $statusCode);
    }
}