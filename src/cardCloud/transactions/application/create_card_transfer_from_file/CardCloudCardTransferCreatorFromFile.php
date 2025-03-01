<?php declare(strict_types=1);

namespace Viabo\cardCloud\transactions\application\create_card_transfer_from_file;

use Viabo\cardCloud\shared\domain\CardCloudRepository;

final readonly class CardCloudCardTransferCreatorFromFile
{
    public function __construct(private CardCloudRepository $repository)
    {
    }

    public function __invoke(string $businessId, string $subAccount, array $fileData): void
    {
        $cards = array_map(function (array $data) {
            return ['card_id' => $data[0], 'amount' => $data[3], 'description' => $data[4]];
        }, $fileData);
        $this->repository->createTransferFromFile($businessId, $subAccount, ['cards' => $cards]);
    }
}
