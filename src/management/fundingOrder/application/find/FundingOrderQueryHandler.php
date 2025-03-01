<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\find;


use Viabo\management\fundingOrder\domain\FundingOrderId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class FundingOrderQueryHandler implements QueryHandler
{
    public function __construct(private FundingOrderFinder $finder)
    {
    }

    public function __invoke(FundingOrderQuery $query): Response
    {
        $fundingOrderId = FundingOrderId::create($query->fundingOrderId);
        return $this->finder->__invoke($fundingOrderId);
    }
}