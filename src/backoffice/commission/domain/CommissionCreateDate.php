<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain;


use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class CommissionCreateDate extends DateTimeValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }
}