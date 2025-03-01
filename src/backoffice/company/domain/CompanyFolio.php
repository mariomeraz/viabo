<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyFolio extends StringValueObject
{
    public static function create(string $folio): static
    {
        return new static((string) ++$folio);
    }

    public static function empty(): static
    {
        return new static('');
    }

}