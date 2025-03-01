<?php declare(strict_types=1);


namespace Viabo\management\shared\domain\card;


use Viabo\management\credential\domain\exceptions\CardIdEmpty;
use Viabo\shared\domain\valueObjects\UuidValueObject;

final class CardId extends UuidValueObject
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

    public static function empty(): CardId
    {
        $cardId = self::random();
        $cardId->value = '';
        return $cardId;
    }
}