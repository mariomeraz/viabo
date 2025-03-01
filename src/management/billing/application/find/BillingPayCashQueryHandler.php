<?php declare(strict_types=1);


namespace Viabo\management\billing\application\find;


use Viabo\management\billing\domain\BillingReferencePayCash;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class BillingPayCashQueryHandler implements QueryHandler
{
    public function __construct(private BillingPayCashFinder $finder)
    {
    }

    public function __invoke(BillingPayCashQuery $query): Response
    {
        $reference = new BillingReferencePayCash($query->referencePayCash);
        return $this->finder->__invoke($reference);
    }
}