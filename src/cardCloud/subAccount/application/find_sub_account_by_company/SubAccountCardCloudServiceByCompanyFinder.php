<?php declare(strict_types=1);

namespace Viabo\cardCloud\subAccount\application\find_sub_account_by_company;

use Viabo\cardCloud\cards\application\CardCloudServiceResponse;
use Viabo\cardCloud\shared\domain\CardCloudRepository;
use Viabo\cardCloud\subAccount\application\create_sub_account\CardCloudSubAccountResponse;

final readonly class SubAccountCardCloudServiceByCompanyFinder
{
    public function __construct(private CardCloudRepository $repository)
    {
    }

    public function __invoke(string $businessId, string $subAccountId): CardCloudSubAccountResponse
    {
        return new CardCloudSubAccountResponse(
            $this->repository->searchSubAccount($businessId, $subAccountId)
        );
    }
}
