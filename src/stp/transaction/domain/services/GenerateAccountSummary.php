<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\services;


use Viabo\shared\domain\utils\NumberFormat;

final readonly class GenerateAccountSummary
{
    public function __invoke(array $transactions): array
    {
        $charges = $this->sum($transactions, 'Salida');
        $credits = $this->sum($transactions, 'Entrada');
        $closingBalance = $this->lastBalance($transactions);
        $openingBalance = $closingBalance + $charges - $credits;

        return [
            'openingBalance' => NumberFormat::money($openingBalance),
            'credits' => NumberFormat::money($credits),
            'charges' => NumberFormat::money($charges),
            'closingBalance' => NumberFormat::money($closingBalance)
        ];
    }

    private function sum(array $transactions, string $type): float
    {
        $filterTransactions = array_filter($transactions, function (array $transaction) use ($type) {
            return $transaction['typeName'] === $type;
        });

        return array_sum(array_map(function (array $transaction) {
            return $transaction['amount'];
        }, $filterTransactions));
    }

    private function lastBalance(array $transactions): float
    {
        if (empty($transactions)) {
            return 0;
        }

        $last = end($transactions);
        return floatval($last['destinationBalance']);
    }
}