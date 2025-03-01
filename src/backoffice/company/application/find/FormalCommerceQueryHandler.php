<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class FormalCommerceQueryHandler implements QueryHandler
{
    public function __construct(private FormalCommerceFinder $finder)
    {
    }

    public function __invoke(FormalCommerceQuery $query): Response
    {
        $commerceId = CompanyId::create($query->commerceId);
        return ($this->finder)($commerceId);
    }
}