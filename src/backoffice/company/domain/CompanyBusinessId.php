<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyBusinessId extends StringValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }

}