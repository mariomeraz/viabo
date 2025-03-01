<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_statement_account_by_stp_account_for_pdf;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class StatementAccountQueryHandlerByStpAccountForPdf implements QueryHandler
{
    public function __construct(private StatementAccountFinderByStpAccount $finder)
    {
    }

    public function __invoke(StatementAccountQueryByStpAccountForPdf $query): Response
    {
        return $this->finder->__invoke($query->stpAccount, $query->month,$query->year);
    }
}