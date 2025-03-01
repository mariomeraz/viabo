<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company_by_bank_account;


use Viabo\shared\domain\bus\query\Query;

final readonly class CompanyQueryByBankAccount implements Query
{
    public function __construct(public string $bankAccountNumber, public string $businessId = '')
    {
    }
}