<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\events;


use Viabo\shared\domain\bus\event\EventBus;
use Viabo\stp\transaction\domain\services\StatusFinder;
use Viabo\stp\transaction\domain\services\TransactionTypeFinder;
use Viabo\stp\transaction\domain\Transaction;
use Viabo\stp\transaction\domain\TransactionRepository;

final readonly class StpTransactionCreatorByInternalTransaction
{
    public function __construct(
        private TransactionRepository $repository,
        private TransactionTypeFinder $typeFinder,
        private StatusFinder          $statusFinder,
        private EventBus              $bus
    )
    {
    }

    public function __invoke(array $transaction): void
    {
        $speiInType = $this->typeFinder->speiInType();
        $statusId = $this->statusFinder->liquidated();
        $transaction['trackingKey'] = 'INTERNAL';
        $transaction = Transaction::fromInternalSpeiIn($transaction, $speiInType, $statusId);
        $this->repository->save($transaction);

        $this->bus->publish(...$transaction->pullDomainEvents());
    }
}