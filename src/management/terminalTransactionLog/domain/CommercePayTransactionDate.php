<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\domain;

use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class CommercePayTransactionDate extends DateTimeValueObject
{

    public function now(): string
    {
        return $this->date->formatDateTime($this->value , 'YmdHis');
    }

    public function format($value):string
    {
        return $this->date->formatDateTime($value, 'Y-m-d H:i:s');
    }
}
