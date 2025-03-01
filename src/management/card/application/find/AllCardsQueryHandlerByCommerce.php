<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class AllCardsQueryHandlerByCommerce implements QueryHandler
{
    public function __construct(private AllCardsFinderByCommerce $finder)
    {
    }

    public function __invoke(AllCardsQueryByCommerce $query): Response
    {
        return $this->finder->__invoke($query->commerceId);
    }
}