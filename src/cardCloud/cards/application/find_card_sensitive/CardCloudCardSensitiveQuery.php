<?php declare(strict_types=1);

namespace Viabo\cardCloud\cards\application\find_card_sensitive;

use Viabo\shared\domain\bus\query\Query;

final readonly class CardCloudCardSensitiveQuery implements Query
{
    public function __construct(public string $businessId, public string $cardId)
    {
    }
}
