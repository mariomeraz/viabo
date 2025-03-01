<?php declare(strict_types=1);

namespace Viabo\cardCloud\subAccount\application\find_sub_account_movements_by_company;

use Viabo\cardCloud\shared\domain\CardCloudRepository;
use Viabo\cardCloud\subAccount\application\create_sub_account\CardCloudSubAccountResponse;

final readonly class SubAccountCardCloudServiceMovementsByCompanyFinder
{
    public function __construct(private CardCloudRepository $repository)
    {
    }

    public function __invoke(
        string  $businessId,
        string  $subAccountId,
        ?string $fromDate,
        ?string $toDate
    ): CardCloudSubAccountResponse
    {
        return new CardCloudSubAccountResponse(
            $this->repository->searchMovements($businessId, $subAccountId, $fromDate, $toDate)
        );
    }
}
