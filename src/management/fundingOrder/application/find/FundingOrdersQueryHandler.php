<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class FundingOrdersQueryHandler implements QueryHandler
{
    public function __construct(private FundingOrdersFinder $finder)
    {
    }

    public function __invoke(FundingOrdersQueryByCards $query): Response
    {
        return $this->finder->__invoke($query->cardsData);
    }
}