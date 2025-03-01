<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\create_commission_transaction_by_internal_transaction;


use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\stp\stpAccount\application\find_stp_account_by_business\StpAccountQueryByBusiness;
use Viabo\stp\transaction\domain\services\StatusFinder;
use Viabo\stp\transaction\domain\services\TransactionTypeFinder;
use Viabo\stp\transaction\domain\Transaction;
use Viabo\stp\transaction\domain\TransactionRepository;

final readonly class CommissionTransactionCreatorByTransactionCreated
{
    public function __construct(
        private TransactionRepository $repository,
        private TransactionTypeFinder $typeFinder,
        private StatusFinder          $statusFinder,
        private QueryBus              $queryBus
    )
    {
    }

    public function __invoke(array $transaction): void
    {
        $commissionTotal = $this->commissionTotal($transaction['commissions']);
        if ($this->hasCommissions($commissionTotal)) {
            $stpAccount = $this->queryBus->ask(new StpAccountQueryByBusiness($transaction['businessId']));
            $transaction['trackingKey'] = "REFERENCE-{$transaction['reference']}";
            $transaction['concept'] = "Comisión Cobrada por la transacción {$transaction['reference']}";
            $transaction['amount'] = $commissionTotal;
            $transaction['reference'] = $transaction['reference'] . '01';
            $transaction['sourceAccount'] = '1';
            $transaction['sourceName'] = 'N/A';
            $transaction['sourceEmail'] = '';
            $transaction['destinationAccount'] = $stpAccount->data['number'];
            $transaction['destinationName'] = $stpAccount->data['company'];
            $transaction['destinationEmail'] = '';
            $speiInType = $this->typeFinder->speiInType();
            $statusId = $this->statusFinder->liquidated();
            $transaction = Transaction::fromInternalSpeiIn($transaction, $speiInType, $statusId);
            $this->repository->save($transaction);
        }

    }

    private function commissionTotal(array|string $commissions): float|int
    {
        if (empty($commissions)) {
            return 0;
        }
        unset($commissions['total']);
        return array_sum($commissions);
    }

    private function hasCommissions(float|int $commission): bool
    {
        return $commission > 0;
    }
}