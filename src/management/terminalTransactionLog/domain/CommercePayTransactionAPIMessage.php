<?php declare(strict_types=1);


namespace Viabo\management\terminalTransactionLog\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayTransactionAPIMessage extends StringValueObject
{
    public function update(string $value): static
    {
        return new static($value);
    }
}