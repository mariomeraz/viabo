<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\services;


use Viabo\shared\domain\utils\NumberFormat;
use Viabo\stp\transaction\domain\exceptions\TransactionInsufficientBalance;

final readonly class BalanceValidator
{
    public function __invoke(array $originAccount, array $accounts, bool $internal = false): void
    {
        $total = array_sum(array_map(function (array $account) use ($originAccount, $internal) {
            $amount = NumberFormat::float($account['amount']);
            $commissions = $this->calculateCommissions($amount, $originAccount['commissions'], $internal);
            return $originAccount['type'] === 'stpAccount' ? $amount : $commissions;
        }, $accounts));

        if ($total > $originAccount['balance'] || $total > $originAccount['realBalance']) {
            throw new TransactionInsufficientBalance();
        }
    }

    private function calculateCommissions(float $amount, array $commissions, bool $internal): float
    {
        if (empty($commissions)) {
            return $amount;
        }

        $feeStpCommission = $internal ? 0 : $commissions['feeStp'];
        $speitOutCommission = $internal ? $commissions['internal'] : $commissions['speiOut'];
        $speitOutCommission = $amount * $speitOutCommission / 100;
        return $amount + $speitOutCommission + $feeStpCommission;

    }

}