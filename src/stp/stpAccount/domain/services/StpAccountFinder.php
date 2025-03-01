<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\domain\services;


use Viabo\stp\stpAccount\domain\StpAccount;
use Viabo\stp\stpAccount\domain\StpAccountRepository;
use Viabo\stp\stpAccount\domain\exceptions\StpAccountNotExist;

final readonly class StpAccountFinder
{
    public function __construct(private StpAccountRepository $repository)
    {
    }

    public function __invoke(
        string $profileId ,
        string $userStpAccountId ,
        string $commerceStpAccountId
    ): stpAccount
    {
        $this->ensureAccountId($userStpAccountId , $commerceStpAccountId);

        $adminProfileStp = '5';
        $stpAccountId = $profileId === $adminProfileStp ? $userStpAccountId : $commerceStpAccountId;
        $stpAccount = $this->repository->search($stpAccountId);

        if (empty($stpAccount)) {
            throw new StpAccountNotExist();
        }

        return $stpAccount;
    }

    private function ensureAccountId(string $userStpAccountId , string $commerceStpAccountId): void
    {
        if (empty($userStpAccountId) && empty($commerceStpAccountId)) {
            throw new StpAccountNotExist();
        }
    }
}