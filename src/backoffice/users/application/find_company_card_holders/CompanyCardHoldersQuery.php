<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\find_company_card_holders;


use Viabo\shared\domain\bus\query\Query;

final readonly class CompanyCardHoldersQuery implements Query
{
    public function __construct(public string $companyId)
    {
    }
}
