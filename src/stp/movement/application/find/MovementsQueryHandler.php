<?php declare(strict_types=1);


namespace Viabo\stp\movement\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class MovementsQueryHandler implements QueryHandler
{
    public function __construct(private MovementsFinder $finder)
    {
    }

    public function __invoke(MovementsQuery $query): Response
    {
        return $this->finder->__invoke($query->stpAccount);
    }
}