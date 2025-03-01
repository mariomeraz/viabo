<?php declare(strict_types=1);

namespace Viabo\cardCloud\cards\application\find_sub_account_cards;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudSubAccountCardsQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudSubAccountCardsFinder $finder)
    {
    }

    public function __invoke(CardCloudSubAccountCardsQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId, $query->subAccountId, $query->owners);
    }
}
