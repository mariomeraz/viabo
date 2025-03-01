<?php declare(strict_types=1);

namespace Viabo\management\cardMovement\application\find;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardsMasterMovementsQueryHandler implements QueryHandler
{
    public function __construct(private MasterCardsMovementsFinder $finder)
    {
    }

    public function __invoke(CardsMasterMovementsQuery $query):Response
    {
        return $this->finder->__invoke(
            $query->cardsInformation ,
            $query->operations ,
            $query->payTransactions ,
            $query->initialDate ,
            $query->finalDate
        );
    }
}
