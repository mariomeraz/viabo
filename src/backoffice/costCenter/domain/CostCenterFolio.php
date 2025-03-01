<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CostCenterFolio extends StringValueObject
{
    public static function create(string $folio): static
    {
        return new static((string) ++$folio);
    }
}