<?php declare(strict_types=1);


namespace Viabo\management\billing\application\find;


use Viabo\management\billing\domain\BillingApiKey;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class DepositReferenceQueryHandler implements QueryHandler
{
    public function __construct(private DepositReferenceFinder $finder)
    {
    }

    public function __invoke(DepositReferenceQuery $query): Response
    {
        $apiReference = BillingApiKey::create($query->apiKey);
        return $this->finder->__invoke($apiReference);
    }
}