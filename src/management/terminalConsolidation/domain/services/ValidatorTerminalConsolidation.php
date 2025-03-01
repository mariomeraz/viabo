<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\domain\services;

use Viabo\management\terminalConsolidation\domain\exceptions\TerminalConsolidationNotMath;
use Viabo\management\terminalConsolidation\domain\TerminalConsolidationSpeiCardTransactionAmount;

final readonly class ValidatorTerminalConsolidation
{
    public function __construct()
    {
    }

    public function __invoke(
        TerminalConsolidationSpeiCardTransactionAmount $speiCardTransactionAmount,
        mixed                                         $threshold,
        array                                          $transactions
    ):void
    {
        $total = $this->calculateTotalTransactions($transactions);
        $inferiorLimit = $this->calculateInferiorLimit($total,intval($threshold));

        if(!$this->validateAmountConsolidation($speiCardTransactionAmount,$total,$inferiorLimit)){
            throw new TerminalConsolidationNotMath();
        }

    }

    public function calculateTotalTransactions(array $transactions): mixed
    {
        $suma = 0;
        foreach ($transactions as $transaction) {
            $suma += $transaction['amount'];
        }
        return $suma;
    }
    public function calculateInferiorLimit(int $total,mixed $threshold): float|int
    {
        return $total * (1 - ($threshold / 100));
    }

    public function validateAmountConsolidation(
        TerminalConsolidationSpeiCardTransactionAmount $speiCardTransactionAmount,
        int                                            $total,
        mixed                                          $inferiorLimit
    ): bool
    {
        return floatval($speiCardTransactionAmount->value()) >= $inferiorLimit && floatval($speiCardTransactionAmount->value()) <= $total;
    }
}
