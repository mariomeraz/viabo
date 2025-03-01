<?php declare(strict_types=1);


namespace Viabo\security\code\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CodeValue extends StringValueObject
{
    public static function random(): self
    {
        return new self(self::generate());
    }

    private static function generate(): string
    {
        return strval(random_int(100000,999999));
    }

    public function isNotSame(string $verificationCode): bool
    {
        return $verificationCode !== $this->value;
    }
}