<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;
use Viabo\cardCloud\users\domain\exceptions\UserCardCloudOwnerIdEmpty;

final class UserCardCloudOwnerId extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new UserCardCloudOwnerIdEmpty();
        }
    }
}