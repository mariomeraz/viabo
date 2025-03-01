<?php declare(strict_types=1);

namespace Viabo\cardCloud\subAccount\domain\services;

use Viabo\cardCloud\shared\domain\CardCloudRepository;

final readonly class CardCloudSubAccountFinder
{
    public function __construct(private CardCloudRepository $repository)
    {
    }

    public function __invoke(string $businessId, string $rfc): array
    {
        return $this->getSubAccount($businessId, $rfc);
    }

    public function getSubAccount(string $businessId, string $rfc): array
    {
        $accounts = $this->repository->searchSubAccounts($businessId);
        $subAccount = array_filter($accounts['subaccounts'], function (array $account) use ($rfc) {
            return $account['description'] === $rfc;
        });
        $subAccount = array_values($subAccount);
        return $subAccount[0] ?? [];
    }
}
