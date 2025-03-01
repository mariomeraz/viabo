<?php declare(strict_types=1);

namespace Viabo\cardCloud\cards\application\find_card_movements;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final  readonly class CardCloudCardMovementsQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudCardMovementsFinder $finder)
    {
    }

    public function __invoke(CardCloudCardMovementsQuery $query): Response
    {
        return $this->finder->__invoke(
            $query->businessId,
            $query->cardId,
            $query->fromDate,
            $query->toDate
        );
    }
}
