<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\create_spei_out_transaction;


use Viabo\shared\domain\bus\event\EventBus;
use Viabo\stp\shared\domain\stp\StpRepository;
use Viabo\stp\transaction\domain\events\StpTransactionCreatedDomainEvent;
use Viabo\stp\transaction\domain\services\AccountsDataFinder;
use Viabo\stp\transaction\domain\services\BalanceValidator;
use Viabo\stp\transaction\domain\services\OriginAccountDataFinder;
use Viabo\stp\transaction\domain\services\TransactionsCreator;
use Viabo\stp\transaction\domain\Transaction;
use Viabo\stp\transaction\domain\TransactionRepository;
use Viabo\stp\transaction\domain\Transactions;

final readonly class SpeiOutTransactionCreator
{

    public function __construct(
        private TransactionRepository   $repository,
        private StpRepository           $stpRepository,
        private OriginAccountDataFinder $originAccountDataFinder,
        private BalanceValidator        $balanceValidator,
        private AccountsDataFinder      $accountsDataFinder,
        private TransactionsCreator     $transactionsCreator,
        private EventBus                $bus
    )
    {
    }

    public function __invoke(
        string $userId,
        string $businessId,
        string $originBankAccount,
        array  $destinationsAccounts,
        string $concept,
        bool   $isInternalTransaction
    ): void
    {

        $originAccount = $this->originAccountDataFinder->__invoke($originBankAccount, $isInternalTransaction);
        $this->balanceValidator->__invoke($originAccount, $destinationsAccounts, $isInternalTransaction);
        $destinationsAccounts = $this->accountsDataFinder->__invoke(
            $businessId,
            $destinationsAccounts,
            $isInternalTransaction
        );
        $transactions = $this->transactionsCreator->__invoke(
            $originAccount,
            $destinationsAccounts,
            $concept,
            $userId,
            $isInternalTransaction
        );
        $this->registerTransaction($transactions, $originAccount, $isInternalTransaction);
    }

    private function registerTransaction(
        Transactions $transactions,
        array        $stpAccount,
        bool         $internalTransaction
    ): void
    {
        $second = 0;
        array_map(function (Transaction $transaction) use ($stpAccount, $internalTransaction, &$second) {
            $transaction->incrementTrackingKey($second++);
            $transaction->incrementReference($second++);

            if ($transaction->isExternalTransaction()) {
                $stpData = $this->stpRepository->processPayment($stpAccount, $transaction->toArray());
                $transaction->updateStpData($stpData);
            }
            $this->repository->save($transaction);

            $this->bus->publish(new StpTransactionCreatedDomainEvent($transaction->id(), $transaction->toArray()));
        }, $transactions->elements());
    }
}