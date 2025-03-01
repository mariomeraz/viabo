<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CommerceQueryHandler implements QueryHandler
{
    public function __construct(private CommerceFinder $finder)
    {
    }

    public function __invoke(CommerceQuery $query): Response
    {
        $commerceId = CompanyId::create($query->commerceId);
        return $this->finder->__invoke($commerceId);
    }
}