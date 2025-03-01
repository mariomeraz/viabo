<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_statement_account;


use Viabo\stp\transaction\application\TransactionResponse;
use Viabo\stp\transaction\domain\services\StatementAccountFinder as StatementAccountFinderService;

final readonly class StatementAccountFinder
{
    public function __construct(private StatementAccountFinderService $finder)
    {
    }

    public function __invoke(int $account, int $month, int $year): TransactionResponse
    {
        $transactions = $this->finder->__invoke($account, $month, $year);
        return new TransactionResponse($this->deleteData($transactions));
    }

    private function deleteData(array $transactions): array
    {
        return array_map(function (array $data) {
            unset(
                $data['businessId'],
                $data['typeId'],
                $data['statusId'],
                $data['sourceEmail'],
                $data['sourceBalance'],
                $data['sourceBalanceMoneyFormat'],
                $data['destinationEmail'],
                $data['destinationBalance'],
                $data['destinationBalanceMoneyFormat'],
                $data['amountMoneyFormat'],
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