<?php declare(strict_types=1);

namespace Viabo\backoffice\users\application\find_company_card_holders;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CompanyCardHoldersQueryHandler implements QueryHandler
{
    public function __construct(private CompanyCardHoldersFinder $finder)
    {
    }

    public function __invoke(CompanyCardHoldersQuery $query): Response
    {
        return $this->finder->__invoke($query->companyId);
    }

}
