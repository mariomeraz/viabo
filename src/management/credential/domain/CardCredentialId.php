<?php declare(strict_types=1);


namespace Viabo\management\credential\domain;


use Viabo\management\credential\domain\exceptions\CardIdEmpty;
use Viabo\shared\domain\valueObjects\UuidValueObject;

final class CardCredentialId extends UuidValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CardIdEmpty();
        }
    }
}