<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_statement_account_by_stp_account_for_pdf;


use Viabo\shared\domain\bus\query\Query;

final readonly class StatementAccountQueryByStpAccountForPdf implements Query
{
    public function __construct(public array $stpAccount, public int $month, public int $year)
    {
    }
}