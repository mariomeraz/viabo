<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardMovementsQueryHandler implements QueryHandler
{
    public function __construct(private CardMovementsFinder $finder)
    {
    }

    public function __invoke(CardMovementsQuery $query): Response
    {
        return $this->finder->__invoke(
            $query->card ,
            $query->initialDate ,
            $query->finalDate ,
            $query->operations
        );
    }
}