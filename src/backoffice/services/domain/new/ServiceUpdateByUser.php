<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class ServiceUpdateByUser extends StringValueObject
{
    public static function empty(): static
    {
        return new static('');
    }
}