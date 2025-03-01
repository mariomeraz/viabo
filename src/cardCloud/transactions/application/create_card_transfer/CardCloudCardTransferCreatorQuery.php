<?php declare(strict_types=1);

namespace Viabo\cardCloud\transactions\application\create_card_transfer;

use Viabo\shared\domain\bus\query\Query;

final readonly class CardCloudCardTransferCreatorQuery implements Query
{
    public function __construct(
        public string $businessId,
        public string $sourceType,
        public string $source,
        public string $destinationType,
        public string $destination,
        public float  $amount,
        public string $description
    )
    {
    }
}
