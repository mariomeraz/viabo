<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\find;


use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CommissionChargeQueryHandler implements QueryHandler
{
    public function __construct(private CommissionChargeFinder $finder)
    {
    }

    public function __invoke(CommissionChargeQuery $query): Response
    {
        $commerceId = CompanyId::create($query->commerceId);
        $amount = floatval($query->amount);

        return $this->finder->__invoke($commerceId , $query->paymentProcessor, $amount);
    }
}