<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update_company_balance_by_stp;


use Viabo\backoffice\company\domain\Company;
use Viabo\backoffice\company\domain\CompanyRepository;
use Viabo\backoffice\company\domain\events\CompanyBalanceUpdatedDomainEventByTransactionCreated;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CompanyBalanceUpdaterByStp
{
    public function __construct(
        private CompanyRepository $repository,
        private EventBus          $bus
    )
    {
    }

    public function __invoke(array $transaction): void
    {
        $sourceCompany = $this->repository->search($transaction['additionalData']['sourceCompanyId']);
        $destinationCompany = $this->repository->search($transaction['additionalData']['destinationCompanyId']);

        $this->decreaseBalance($sourceCompany, $transaction);
        $this->incrementBalance($destinationCompany, $transaction);

        $this->bus->publish(new CompanyBalanceUpdatedDomainEventByTransactionCreated($transaction['id'], $transaction));
    }

    private function decreaseBalance(?Company $sourceCompany, array $transaction): void
    {
        if (!empty($sourceCompany)) {
            $sourceCompany->decreaseBalance(
                $transaction['amount'],
                $transaction['createdByUser'],
                $transaction['createDate']
            );
            $this->repository->update($sourceCompany);

            $this->bus->publish(...$sourceCompany->pullDomainEvents());
        }
    }

    private function incrementBalance(?Company $destinationCompany, array $transaction): void
    {
        if (!empty($destinationCompany)) {
            $destinationCompany->incrementBalance(
                $transaction['commissions']['total'],
                $transaction['createdByUser'],
                $transaction['createDate']
            );
            $this->repository->update($destinationCompany);

            $this->bus->publish(...$destinationCompany->pullDomainEvents());
        }
    }
}