<?php declare(strict_types=1);

namespace Viabo\cardCloud\cards\application\find_card_details;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudCardDetailsQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudCardDetailsFinder $finder)
    {
    }

    public function __invoke(CardCloudCardDetailsQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId, $query->cardId, $query->owner);
    }
}
