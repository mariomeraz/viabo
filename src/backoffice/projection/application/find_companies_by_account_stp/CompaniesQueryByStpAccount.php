<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_companies_by_account_stp;


use Viabo\shared\domain\bus\query\Query;

final readonly class CompaniesQueryByStpAccount implements Query
{
    public function __construct(public string $stpAccountId)
    {
    }
}