<?php declare(strict_types=1);


namespace Viabo\security\api\domain;


use Viabo\security\api\domain\exceptions\ApiNameEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class ApiName extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new ApiNameEmpty();
        }
    }
}