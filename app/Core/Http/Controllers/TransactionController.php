<?php

declare(strict_types=1);

namespace App\Core\Http\Controllers;

use App\Core\Common\Helpers\JsonResponseTrait;
use App\Modules\Transactions\Domain\Services\Notifications\TransactionNotificationProcessor;
use App\Modules\Transactions\Domain\Services\TransactionService;
use App\Modules\Transactions\Domain\Validators\TransactionRequestValidator;
use App\Modules\Users\Domain\Services\UserService;
use Illuminate\Http\{JsonResponse, Request};
use Laravel\Lumen\Routing\Controller as BaseController;
use Exception;

final class TransactionController extends BaseController
{
    use JsonResponseTrait;

    private TransactionNotificationProcessor $notificationProcessor;
    private TransactionRequestValidator $requestValidator;
    private TransactionService $transactionService;
    private UserService $userService;
    
    public function __construct(
        TransactionNotificationProcessor $notificationProcessor,
        TransactionRequestValidator $requestValidator,
        TransactionService $transactionService,
        UserService $userService
    ) {
        $this->notificationProcessor = $notificationProcessor;
        $this->requestValidator = $requestValidator;
        $this->transactionService = $transactionService;
        $this->userService = $userService;
    }

    public function make(Request $request): JsonResponse
    {
        try {
            $transaction = $this->requestValidator->validate($request->all());
            $payee = $this->userService->getUserById($transaction->payee);

            $this->transactionService->setCurrentTransactionPayload($transaction, $payee);
            $this->transactionService->checkTransactionAcceptanceCriterias();

            $response = $this->transactionService->execute();
            $this->userService->updateUserBalance($response);

            $this->notificationProcessor->add($payee, $transaction->value);
            return JsonResponseTrait::response('Transação realizada com sucesso!');
        } catch (Exception $exception) {
            return JsonResponseTrait::response($exception->getMessage(), [], $exception->getCode());
        }
    }

    public function reverse(Request $request): JsonResponse
    {
        try {
            $transaction = $this->transactionService->getTransactionById(
                $request->input('transaction')
            );

            $this->transactionService->setCurrentTransactionPayload($transaction);

            $response = $this->transactionService->reverse();
            $this->userService->updateUserBalance($response);

            return JsonResponseTrait::response('Transação realizada com sucesso!');
        } catch (Exception $exception) {
            return JsonResponseTrait::response($exception->getMessage(), [], $exception->getCode());
        }
    }
}
