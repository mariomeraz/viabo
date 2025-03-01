<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserCardCloudIsPending extends StringValueObject
{
    public static function create(bool $value): static
    {
        $value = $value ? '1' : '0';
        return new static($value);
    }

    public static function false(): static
    {
        return self::create(false);
    }
}