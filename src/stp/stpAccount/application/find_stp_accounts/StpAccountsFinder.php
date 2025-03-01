<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find_stp_accounts;


use Viabo\stp\stpAccount\application\find\StpAccountResponse;
use Viabo\stp\stpAccount\domain\StpAccount;
use Viabo\stp\stpAccount\domain\StpAccountRepository;

final readonly class StpAccountsFinder
{
    public function __construct(private StpAccountRepository $repository)
    {
    }

    public function __invoke(bool $stpAccountsDisable): StpAccountResponse
    {
        $stpAccountsDisable = $stpAccountsDisable ? '0' : '1';
        $accounts = $this->repository->searchAll($stpAccountsDisable);
        return new StpAccountResponse(array_map(function (StpAccount $account) {
            return $account->decrypt();
        }, $accounts));
    }
}