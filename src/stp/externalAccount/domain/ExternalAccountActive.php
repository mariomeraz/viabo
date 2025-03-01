<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class ExternalAccountActive extends StringValueObject
{
    public static function enable(): static
    {
        return new static('1');
    }

    public function disable(): static
    {
        return new static('0');
    }
}