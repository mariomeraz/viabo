<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\domain;


final class CommercePayTransactionGlobalAmount
{
    public function __construct(private float $amount = 0)
    {
    }

    public function sum(float $value):void
    {
        $this->amount += $value;
    }

    public function total(): float
    {
        return empty($this->amount)? 0 : $this->amount;
    }
}
