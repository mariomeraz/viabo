<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayLiquidationStatusId extends StringValueObject
{
    private const UNLIQUIDATED = '12';

    public static function unLiquidated(): static
    {
        return new static(self::UNLIQUIDATED);
    }

    public function update(string $value): static
    {
        return new static($value);
    }
}