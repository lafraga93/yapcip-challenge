<?php

declare(strict_types=1);

namespace App\Core\Http\Controllers;

use App\Core\Common\Factories\BaseFactory;
use App\Core\Common\Helpers\JsonResponseTrait;
use App\Modules\Transactions\Domain\Services\TransactionService;
use App\Modules\Transactions\Domain\Validators\TransactionRequestValidator;
use Illuminate\Http\{JsonResponse, Request};
use Laravel\Lumen\Routing\Controller as BaseController;
use Exception;

final class TransactionController extends BaseController
{
    use JsonResponseTrait;

    private TransactionService $service;

    public function __construct(TransactionService $transactionService)
    {
        $this->service = $transactionService;
    }

    public function makeTransaction(Request $request): JsonResponse
    {
        try {
            $requestValidatorInstance = BaseFactory::create(TransactionRequestValidator::class);

            $transactionData = $requestValidatorInstance->validate(
                $request->all()
            );

            $this->service->execute($transactionData);
            return JsonResponseTrait::response('Transação realizada com sucesso!');
        } catch (Exception $exception) {
            return JsonResponseTrait::response($exception->getMessage(), [], $exception->getCode());
        }
    }
}
