<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CompanyQueryHandler implements QueryHandler
{
    public function __construct(private CompanyFinder $finder)
    {
    }

    public function __invoke(CompanyQuery $query): Response
    {
        return $this->finder->__invoke($query->companyId);
    }
}