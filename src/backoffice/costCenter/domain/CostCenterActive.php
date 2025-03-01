<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CostCenterActive extends StringValueObject
{
    public static function enable(): static
    {
        return new static('1');
    }
}