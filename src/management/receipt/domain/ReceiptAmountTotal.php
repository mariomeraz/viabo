<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain;


use Viabo\shared\domain\valueObjects\DecimalValueObject;

final class ReceiptAmountTotal extends DecimalValueObject
{
    public static function create(float $value): static
    {
        return new static($value);
    }
}