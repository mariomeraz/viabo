<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class AllCardsOperationsQueryHandler implements QueryHandler
{
    public function __construct(private AllCardsOperationsFinder $finder)
    {
    }

    public function __invoke(AllCardsOperationsQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}