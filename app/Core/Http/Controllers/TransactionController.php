<?php

declare(strict_types=1);

namespace App\Core\Http\Controllers;

use App\Core\Common\Helpers\JsonResponseTrait;
use App\Modules\Transactions\Domain\Services\Notifications\TransactionNotificationService;
use App\Modules\Transactions\Domain\Services\TransactionService;
use App\Modules\Transactions\Domain\Validators\TransactionRequestValidator;
use App\Modules\Users\Domain\Services\UserService;
use Illuminate\Http\{JsonResponse, Request};
use Laravel\Lumen\Routing\Controller as BaseController;
use Exception;

final class TransactionController extends BaseController
{
    use JsonResponseTrait;

    private TransactionNotificationService $notificationService;
    private TransactionRequestValidator $requestValidator;
    private TransactionService $transactionService;
    private UserService $userService;
    
    public function __construct(
        TransactionNotificationService $notificationService,
        TransactionRequestValidator $requestValidator,
        TransactionService $transactionService,
        UserService $userService
    ) {
        $this->notificationService = $notificationService;
        $this->requestValidator = $requestValidator;
        $this->transactionService = $transactionService;
        $this->userService = $userService;
    }

    public function makeTransaction(Request $request): JsonResponse
    {
        try {
            $transaction = $this->requestValidator->validate(
                $request->all()
            );

            $payer = $this->userService->getUserById($transaction->payer);
            $payee = $this->userService->getUserById($transaction->payee);
            
            $this->transactionService->setCurrentTransactionPayload($transaction, $payer);
            $this->transactionService->checkTransactionAcceptanceCriterias();

            $responseTransaction = $this->transactionService->execute();
            $this->userService->updateUserBalance($responseTransaction);

            $this->notificationService->add(
                $payee,
                $transaction->value
            );

            $responseData = [
                'transaction_id' => $responseTransaction->id,
            ];
    
            return JsonResponseTrait::response(
                'Transação realizada com sucesso!',
                $responseData
            );
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

            return JsonResponseTrait::response('Operação realizada com sucesso!');
        } catch (Exception $exception) {
            return JsonResponseTrait::response($exception->getMessage(), [], $exception->getCode());
        }
    }
}
