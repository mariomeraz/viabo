<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\management\card\domain\exceptions\CardExpirationDateEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardExpirationYear extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CardExpirationDateEmpty();
        }
    }
}