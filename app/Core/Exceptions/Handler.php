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
        $statusCode = $exception->getCode();

        if ($statusCode !== 0) {
            return JsonResponseTrait::response($exception->getMessage(), [], $statusCode);
        }

        return JsonResponseTrait::response('Não foi possível processar a requisição.', [], 500);
    }
}
