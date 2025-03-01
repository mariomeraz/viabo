<?php declare(strict_types=1);


namespace Viabo\security\userLog\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserLogData extends StringValueObject
{
    public static function create(array $value): static
    {
        $value = json_encode($value);
        return new static($value);
    }
}