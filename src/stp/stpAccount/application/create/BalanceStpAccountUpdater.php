<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\create;


use Viabo\stp\shared\domain\stp\StpRepository;
use Viabo\stp\stpAccount\domain\services\StpAccountFinderByCriteria;
use Viabo\stp\stpAccount\domain\StpAccount;
use Viabo\stp\stpAccount\domain\StpAccountRepository;

final readonly class BalanceStpAccountUpdater
{
    public function __construct(
        private StpRepository              $STPRepository,
        private StpAccountRepository       $repository,
        private StpAccountFinderByCriteria $finder
    )
    {
    }

    public function __invoke(string $company, bool $stpAccountsDisable): void
    {
        try {
            $stpAccountActive = $stpAccountsDisable ? '0' : '1';
            $stpAccounts = [];
            if (empty($company)) {
                $stpAccounts = $this->repository->searchAll($stpAccountActive);
            } else {
                $filter = [
                    ['field' => 'company.value', 'operator' => '=', 'value' => $company],
                    ['field' => 'active.value', 'operator' => '=', 'value' => $stpAccountActive]
                ];
                $stpAccounts[] = $this->finder->__invoke($filter);
            }
            $this->updateBalanceStpAccounts($stpAccounts);
        } catch (\DomainException) {
        }
    }

    private function updateBalanceStpAccounts(array $stpAccounts): void
    {
        array_map(function (StpAccount $stpAccount) {
            $balance = $this->STPRepository->searchBalance($stpAccount->decrypt());
            $stpAccount->updateBalance($balance['cargosPendientes'], $balance['saldo']);
            $this->repository->update($stpAccount);
        }, $stpAccounts);
    }
}
