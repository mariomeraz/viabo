<?php declare(strict_types=1);

namespace Viabo\cardCloud\cards\application\find_card_sensitive;

use Viabo\cardCloud\cards\application\CardCloudServiceResponse;
use Viabo\cardCloud\shared\domain\CardCloudRepository;

final readonly class CardCloudCardSensitiveFinder
{
    public function __construct(private CardCloudRepository $repository)
    {
    }

    public function __invoke(string $businessId, string $cardId): CardCloudServiceResponse
    {
        return new CardCloudServiceResponse(
            $this->repository->searchCardSensitive($businessId, $cardId)
        );
    }
}
