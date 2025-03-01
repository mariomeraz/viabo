<?php declare(strict_types=1);


namespace Viabo\backoffice\users\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyUserEmail extends StringValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }

    public function update(string $value): static
    {
        return new static($value);
    }
}