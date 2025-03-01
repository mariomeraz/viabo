<?php declare(strict_types=1);


namespace Viabo\management\terminalTransactionLog\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayTransactionAPIData extends StringValueObject
{
    public function update(array $value): static
    {
        $value = json_encode($value);
        return new static($value);
    }
}