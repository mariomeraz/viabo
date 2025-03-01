<?php declare(strict_types=1);

namespace Viabo\cardCloud\transactions\application\create_card_transfer;

use Viabo\cardCloud\shared\domain\CardCloudRepository;

final readonly class CardCloudCardTransferCreator
{
    public function __construct(private CardCloudRepository $repository)
    {
    }

    public function __invoke(
        string $businessId,
        string $sourceType,
        string $source,
        string $destinationType,
        string $destination,
        float  $amount,
        string $description
    ): CardCloudTransactionsResponse
    {
        $transferData = [
            'sourceType' => $sourceType,
            'source' => $source,
            'destinationType' => $destinationType,
            'destination' => $destination,
            'amount' => $amount,
            'description' => $description
        ];
        return new CardCloudTransactionsResponse(
            $this->repository->createTransfer($businessId, $transferData)
        );
    }
}
