<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\find;


use Viabo\management\fundingOrder\domain\FundingOrderReferenceNumber;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class FundingOrderLeagueDataQueryHandler implements QueryHandler
{
    public function __construct(private FundingOrderLeagueDataFinder $finder)
    {
    }

    public function __invoke(FundingOrderLeagueDataQuery $query): Response
    {
        $referenceNumber = FundingOrderReferenceNumber::create(strval($query->referenceNumber));

        return $this->finder->__invoke($referenceNumber);
    }
}