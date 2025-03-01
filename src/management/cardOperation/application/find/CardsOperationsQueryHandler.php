<?php declare(strict_types=1);

namespace Viabo\management\cardOperation\application\find;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardsOperationsQueryHandler implements QueryHandler
{
    public function __construct(private FinderCardsOperations $finder)
    {
    }

    public function __invoke(CardsOperationsQuery $query): Response
    {
        return $this->finder->__invoke(
            $query->cardsInformation ,
            "$query->initialDate 00:00:00" ,
            "$query->finalDate 23:59:59"
        );
    }
}
