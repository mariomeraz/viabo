<?php declare(strict_types=1);

namespace Viabo\cardCloud\cards\application\update_card_block_status;

use Viabo\shared\domain\bus\query\Query;

final readonly class CardCloudCardBlockStatusUpdaterQuery implements Query
{
    public function __construct(public string $businessId, public string $cardId, public string $blockStatus)
    {
    }
}
