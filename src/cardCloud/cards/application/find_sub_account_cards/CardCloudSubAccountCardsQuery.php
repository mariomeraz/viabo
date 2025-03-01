<?php declare(strict_types=1);

namespace Viabo\cardCloud\cards\application\find_sub_account_cards;

use Viabo\shared\domain\bus\query\Query;

final readonly class CardCloudSubAccountCardsQuery implements Query
{
    public function __construct(
        public string $businessId,
        public string $subAccountId,
        public array  $owners
    )
    {
    }
}
