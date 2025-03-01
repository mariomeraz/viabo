<?php declare(strict_types=1);


namespace Viabo\landingPages\prospect\domain;


use Viabo\landingPages\prospect\domain\exceptions\ProspectEmailEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class ProspectEmail extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new ProspectEmailEmpty();
        }
    }
}