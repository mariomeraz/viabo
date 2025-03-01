<?php declare(strict_types=1);

namespace Viabo\management\cardOperation\application\find;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class BalanceMasterInTransactionQueryHandler implements QueryHandler
{
    public function __construct(private FinderBalanceMasterInTransaction $finder)
    {
    }

    public function __invoke(BalanceMasterInTransactionQuery $query): Response
    {
        return $this->finder->__invoke($query->cardsNumber);
    }
}
