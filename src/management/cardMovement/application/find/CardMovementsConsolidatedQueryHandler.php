<?php declare(strict_types=1);

namespace Viabo\management\cardMovement\application\find;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardMovementsConsolidatedQueryHandler implements QueryHandler
{
    public function __construct(private CardMovementsConsolidatedFinder $finder)
    {
    }

    public function __invoke(CardMovementsConsolidatedQuery $query): Response
    {
        return $this->finder->__invoke(
            $query->startDate ,
            $query->card ,
            $query->movementsConciliated
        );
    }
}
