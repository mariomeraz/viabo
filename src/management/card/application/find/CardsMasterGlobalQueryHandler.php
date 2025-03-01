<?php declare(strict_types=1);

namespace Viabo\management\card\application\find;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardsMasterGlobalQueryHandler implements QueryHandler
{
    public function __construct(private FinderCardsMasterGlobal $finder)
    {
    }

    public function __invoke(CardsMasterGlobalQuery $query):Response
    {
        return $this->finder->__invoke($query->cardsInformation,$query->balanceMaster);
    }
}
