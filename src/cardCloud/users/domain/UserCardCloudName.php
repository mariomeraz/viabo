<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserCardCloudName extends StringValueObject
{
    public static function create(string $value): self
    {
        return new self($value);
    }
}