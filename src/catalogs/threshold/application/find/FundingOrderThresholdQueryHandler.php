<?php declare(strict_types=1);


namespace Viabo\catalogs\threshold\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class FundingOrderThresholdQueryHandler implements QueryHandler
{
    public function __construct(private FundingOrderThresholdFinder $finder)
    {
    }

    public function __invoke(FundingOrderThresholdQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}