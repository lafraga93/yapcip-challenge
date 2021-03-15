<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Domain\Services;

use App\Modules\Transactions\Domain\Validators\Criterias\TransactionCriteriasChecker;
use App\Modules\Transactions\Infrastructure\Repositories\Api\TransactionAuthorizationRepository;
use App\Modules\Transactions\Infrastructure\Repositories\Persistence\TransactionRepository;
use Exception;

final class TransactionService
{
    private TransactionCriteriasChecker $criteriasChecker;
    private TransactionAuthorizationRepository $authorizationRepository;
    private TransactionRepository $transactionRepository;
    
    private array $payload;
    
    public function __construct(
        TransactionCriteriasChecker $criteriasChecker,
        TransactionAuthorizationRepository $authorizationRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->criteriasChecker = $criteriasChecker;
        $this->authorizationRepository = $authorizationRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function setCurrentTransactionPayload(object $transaction, $payee = null): void
    {
        $this->payload = [
            'transaction' => $transaction,
            'payee' => $payee,
        ];
    }

    public function checkTransactionAcceptanceCriterias(): bool
    {
        $this->criteriasChecker->checkPayeeUserType($this->payload['payee']);
        $this->criteriasChecker->checkMinimalTrasnferValue($this->payload['transaction']->value);

        return true;
    }

    public function execute(): object
    {
        $isAuthorized = $this->authorizationRepository->check();

        if (!$isAuthorized) {
            throw new Exception('Erro: Transação não autorizada.', 500);
        }

        return $this->persiste();
    }

    public function reverse(): object
    {
        return $this->persiste();
    }

    public function getTransactionById(int $transactionId): object
    {
        return $this->transactionRepository->getTransactionById($transactionId);
    }

    private function persiste(): object
    {
        return $this->transactionRepository->persiste($this->payload['transaction']);
    }
}
