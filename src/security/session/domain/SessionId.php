<?php declare(strict_types=1);


namespace Viabo\security\session\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class SessionId extends StringValueObject
{
    public static function empty(): static
    {
        return new static('');
    }
}