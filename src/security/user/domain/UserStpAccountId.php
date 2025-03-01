<?php declare(strict_types=1);


namespace Viabo\security\user\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserStpAccountId extends StringValueObject
{
    public static function empty(): static
    {
        return new static('');
    }
}