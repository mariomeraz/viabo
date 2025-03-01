<?php declare(strict_types=1);


namespace Viabo\backoffice\logs\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class LogAggregateId extends StringValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }
}