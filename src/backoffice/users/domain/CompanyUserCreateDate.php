<?php declare(strict_types=1);


namespace Viabo\backoffice\users\domain;


use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class CompanyUserCreateDate extends DateTimeValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }
}