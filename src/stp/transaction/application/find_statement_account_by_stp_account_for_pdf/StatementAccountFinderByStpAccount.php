<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_statement_account_by_stp_account_for_pdf;


use Viabo\shared\domain\utils\NumberFormat;
use Viabo\stp\transaction\application\TransactionResponse;
use Viabo\stp\transaction\domain\services\FormatStpData;
use Viabo\stp\transaction\domain\TransactionRepository;

final readonly class StatementAccountFinderByStpAccount
{
    public function __construct(private TransactionRepository $repository, private FormatStpData $formatStpData)
    {
    }

    public function __invoke(array $stpAccount, int $month, int $year): TransactionResponse
    {
        $transactions = $this->repository->searchByBusinessId("$year$month", $stpAccount['businessId']);

        return new TransactionResponse([
            'type' => 'stpAccount',
            'date' => "$year-$month",
            'company' => ['fiscalName' => $stpAccount['company'], 'bankAccount' => $stpAccount['number']],
            'accountSummary' => $this->accountSummary($transactions),
            'transactions' => $this->formatData($transactions)
        ]);
    }

    private function accountSummary(array $transactions): array
    {
        $openingBalance = $this->calculateOpeningBalance($transactions);
        $credits = $this->sum($transactions, 'credit');
        $charges = $this->sum($transactions, 'charge');
        $closingBalance = $this->calculateClosingBalance($transactions);

        return [
            'openingBalance' => NumberFormat::money($openingBalance),
            'credits' => NumberFormat::money($credits),
            'charges' => NumberFormat::money($charges),
            'closingBalance' => NumberFormat::money($closingBalance)
        ];
    }

    private function calculateOpeningBalance(array $transactions): float
    {
        if (empty($transactions)) {
            return 0;
        }
        return $transactions[0]['balance'] + $transactions[0]['charge'] - $transactions[0]['credit'];
    }

    private function sum(array $transactions, string $type): float
    {
        return array_sum(array_map(function (array $transaction) use ($type) {
            return $transaction[$type];
        }, $transactions));
    }

    private function calculateClosingBalance(array $transactions): float
    {
        if (empty($transactions)) {
            return 0;
        }

        $transaction = end($transactions);
        return floatval($transaction['balance']);
    }

    private function formatData(array $transactions): array
    {
        return array_map(function (array $transaction) {
            $charge = floatval($transaction['charge']);
            $credit = floatval($transaction['credit']);
            $balance = floatval($transaction['balance']);

            if (empty($charge)) {
                $transaction['amountMoneyFormat'] = NumberFormat::money($credit);
                $transaction['sourceBalanceMoneyFormat'] = NumberFormat::money($credit);
                $transaction['destinationBalanceMoneyFormat'] = NumberFormat::money($balance);
            } else {
                $transaction['amountMoneyFormat'] = NumberFormat::money($charge);
                $transaction['destinationBalanceMoneyFormat'] = NumberFormat::money($charge);
                $transaction['sourceBalanceMoneyFormat'] = NumberFormat::money($balance);
            }
            return $transaction;
        }, $transactions);
    }

}