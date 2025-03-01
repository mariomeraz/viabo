<?php declare(strict_types=1);


namespace Viabo\management\terminalTransactionLog\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayTransactionAPICode extends StringValueObject
{
    private const APPROVED = '00';

    public function update(string $value): static
    {
        return new static($value);
    }

    public function isApproved(): bool
    {
        return $this->value === self::APPROVED;
    }
}