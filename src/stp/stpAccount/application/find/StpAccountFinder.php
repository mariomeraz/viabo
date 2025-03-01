<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find;


use Viabo\stp\stpAccount\domain\exceptions\StpAccountNotExist;
use Viabo\stp\stpAccount\domain\StpAccountRepository;

final readonly class StpAccountFinder
{
    public function __construct(private StpAccountRepository $repository)
    {
    }

    public function __invoke(string $stpAccountId): StpAccountResponse
    {
        $account = $this->repository->search($stpAccountId);

        if (empty($account)) {
            throw new StpAccountNotExist();
        }

        return new StpAccountResponse($account->decrypt());
    }
}