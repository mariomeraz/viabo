<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class MastersCardsQueryHandlerByCommerce implements QueryHandler
{
    public function __construct(private MasterCardsFinderByCommerce $finder)
    {
    }

    public function __invoke(MastersCardsQueryByCommerce $query): Response
    {
        $commerceId = CardCommerceId::create($query->commerceId);

        return $this->finder->__invoke($commerceId);
    }
}