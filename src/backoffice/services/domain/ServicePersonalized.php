<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class ServicePersonalized extends StringValueObject
{
    public static function empty(): static
    {
        return new static('0');
    }
}