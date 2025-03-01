<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_statement_account_by_company_for_pdf;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class StatementAccountQueryHandlerByCompanyForPdf implements QueryHandler
{
    public function __construct(private StatementAccountFinderByCompany $finder)
    {
    }

    public function __invoke(StatementAccountQueryByCompanyForPdf $query): Response
    {
        return $this->finder->__invoke($query->account, $query->month, $query->year);
    }
}