<?php

declare(strict_types=1);

namespace App\Modules\Transactions\Domain\Services;

use App\Modules\Transactions\Domain\Validators\Criterias\TransactionCriteriasChecker;
use App\Modules\Transactions\Infrastructure\Repositories\Api\TransactionAuthorizationRepository;
use App\Modules\Transactions\Infrastructure\Repositories\Persistence\TransactionRepository;
use Exception;

final class TransactionService
{
    /** @var string */
    const TRANSFER_SLUG = 'transfer';
 
    /** @var string */
    const ROLLBACK_SLUG = 'rollback';

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

    public function setCurrentTransactionPayload(object $transaction, $payer = null): void
    {
        $this->payload = [
            'transaction' => $transaction,
            'payer' => $payer,
        ];
    }

    public function checkTransactionAcceptanceCriterias(): bool
    {
        $payer = $this->payload['payer'];
        $transactionValue = $this->payload['transaction']->value;

        $this->criteriasChecker->checkPayerUserType($payer);
        $this->criteriasChecker->checkPayerFunds($payer, $transactionValue);
        $this->criteriasChecker->checkMinimalTrasnferValue($transactionValue);

        return true;
    }

    public function execute(): object
    {
        $isAuthorized = $this->authorizationRepository->check();

        if (!$isAuthorized) {
            throw new Exception('Erro: Transação não autorizada.', 500);
        }

        return $this->persiste(self::TRANSFER_SLUG);
    }

    public function reverse(): object
    {
        return $this->persiste(self::ROLLBACK_SLUG);
    }

    public function getTransactionById(int $transactionId): object
    {
        $transaction = $this->transactionRepository->getTransactionById($transactionId);

        if (!$transaction) {
            throw new Exception('Não foi possível recuperar a transação.', 422);
        }

        return $transaction;
    }

    private function persiste(string $transactionTypeSlug): object
    {
        return $this->transactionRepository->persiste($this->payload['transaction'], $transactionTypeSlug);
    }
}
