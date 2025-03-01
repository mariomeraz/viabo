<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardsMovementsQueryHandlerByCommerce implements QueryHandler
{
    public function __construct(private CardsMovementsFinder $finder)
    {
    }

    public function __invoke(CardsMovementsQueryByCommerce $query): Response
    {
        $filters = $query->filters ?? [];
        return $this->finder->__invoke($query->cards , $filters);
    }
}