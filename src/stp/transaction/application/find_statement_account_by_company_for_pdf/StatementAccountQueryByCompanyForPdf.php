<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_statement_account_by_company_for_pdf;


use Viabo\shared\domain\bus\query\Query;

final readonly class StatementAccountQueryByCompanyForPdf implements Query
{
    public function __construct(public int $account, public int $month, public int $year)
    {
    }
}