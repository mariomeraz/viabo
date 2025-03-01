<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\domain;


use Viabo\shared\domain\Collection;
use Viabo\shared\domain\Utils;

final class PharosTransactions extends Collection
{
    public static function fromValues(array $values): self
    {
        return new self(array_map(self::pharosTransactionBuilder() , $values));
    }

    private static function pharosTransactionBuilder(): callable
    {
        return fn(array $value): PharosTransaction => PharosTransaction::fromValues($value);
    }

    public function toArray(): array
    {
        return array_map(function (PharosTransaction $transaction) {
            return $transaction->toArray();
        } , $this->items());
    }

    public function setConciliations(?array $conciliations): void
    {
        array_map(function (PharosTransaction $transaction) use ($conciliations) {
            $transaction->setConciliation($conciliations);
        } , $this->items());
    }

    public function filterTransactionReferences(array $transactionReferences): static
    {
        $items = array_filter($this->items() , function (PharosTransaction $transaction) use ($transactionReferences) {
            return $transaction->isNotTerminalShared() ?:(
                $transaction->isTerminalPhysical() ?: $transaction->belongsToCommerceBy($transactionReferences)
            );
        });

        return new static(Utils::removeDuplicateElements($items));
    }

    public function filterLiquidationTransactionsByReferences(array $transactionReferences): static
    {
        $items = array_filter($this->items() , function (PharosTransaction $transaction) use ($transactionReferences) {
            return $transaction->isSameReference($transactionReferences);
        });

        return new static(Utils::removeDuplicateElements($items));
    }

    public function addAdditionalData(array $transactions): void
    {
        array_map(function (PharosTransaction $transaction) use ($transactions) {
            $transaction->addAdditionalData($transactions);
            return $transaction;
        } , $this->items());
    }

    protected function type(): string
    {
        return PharosTransaction::class;
    }
}