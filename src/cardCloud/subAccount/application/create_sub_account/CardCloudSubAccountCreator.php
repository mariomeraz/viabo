<?php declare(strict_types=1);

namespace Viabo\cardCloud\subAccount\application\create_sub_account;

use Viabo\cardCloud\shared\domain\CardCloudRepository;
use Viabo\cardCloud\subAccount\domain\services\CardCloudSubAccountFinder;

final readonly class CardCloudSubAccountCreator
{
    public function __construct(private CardCloudRepository $repository, private CardCloudSubAccountFinder $subAccountFinder)
    {
    }

    public function __invoke(string $businessId, string $companyId, string $rfc): CardCloudSubAccountResponse
    {
        $subAccount = $this->subAccountFinder->__invoke($businessId, $rfc);
        $subAccount = $this->createSubAccount($subAccount, $businessId, $companyId, $rfc);
        return new CardCloudSubAccountResponse($subAccount);
    }

    public function createSubAccount(array $subAccount, string $businessId, string $companyId, string $rfc): array
    {
        if (empty($subAccount)) {
            $subAccount = $this->repository->createAccount($businessId, $companyId, $rfc);
        }
        return $subAccount;
    }
}
