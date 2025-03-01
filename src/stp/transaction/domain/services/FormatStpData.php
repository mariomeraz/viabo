<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\services;


final readonly class FormatStpData
{
    public function __invoke(array $stpTransactions, array $stpAccount): array
    {
        return array_map(function (array $transaction) use ($stpAccount) {
            $transaction['id'] = strval($transaction['id'] ?? $transaction['idEF']);
            $transaction['api'] = $transaction;
            $transaction['stpAccountId'] = $stpAccount['id'];
            $transaction['stpAccountNumber'] = $stpAccount['number'];
            $transaction['businessId'] = $stpAccount['businessId'];
            $transaction['stpAccountBalance'] = $stpAccount['balance'];
            return $transaction;
        }, $stpTransactions);
    }
}