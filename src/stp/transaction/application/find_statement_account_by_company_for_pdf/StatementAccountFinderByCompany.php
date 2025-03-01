<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_statement_account_by_company_for_pdf;


use Viabo\stp\transaction\application\TransactionResponse;
use Viabo\stp\transaction\domain\services\GenerateAccountSummary;
use Viabo\stp\transaction\domain\services\StatementAccountFinder as StatementAccountFinderService;

final readonly class StatementAccountFinderByCompany
{
    public function __construct(
        private StatementAccountFinderService $finder,
        private GenerateAccountSummary        $accountSummary
    )
    {
    }

    public function __invoke(int $account, int $month, int $year): TransactionResponse
    {
        $transactions = $this->finder->__invoke($account, $month, $year);
        $accountSummary = $this->accountSummary->__invoke($transactions);

        return new TransactionResponse([
            'type' => 'company',
            'date' => "$year-$month",
            'accountSummary' => $accountSummary,
            'transactions' => $this->deleteData($transactions)
        ]);
    }

    private function deleteData(array $transactions): array
    {
        return array_map(function (array $data) {
            unset(
                $data['businessId'],
                $data['typeId'],
                $data['statusId'],
                $data['sourceEmail'],
                $data['destinationEmail'],
                $data['urlCEP'],
                $data['receiptUrl'],
                $data['apiData'],
                $data['createdByUser'],
                $data['createDate'],
                $data['active'],
                $data['additionalData']
            );
            return $data;
        }, $transactions);
    }

}