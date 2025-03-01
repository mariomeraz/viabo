<?php declare(strict_types=1);


namespace Viabo\management\shared\domain\card;


use Viabo\management\card\domain\exceptions\CardNumberEmpty;
use Viabo\management\card\domain\exceptions\CardNumberNot8Digits;
use Viabo\management\card\domain\exceptions\CardNumberNotDigits;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardNumber extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function empty(): static
    {
        return new static('');
    }

    public static function createNotEmpty(string $value): static
    {
        self::validateNotEmpty($value);
        return new static($value);
    }

    public static function validate(string $value): void
    {
        if (self::hasNot16Digits($value)) {
            throw new CardNumberNotDigits();
        }

        if (empty($value)) {
            throw new CardNumberEmpty();
        }
    }

    public static function createLast8Digits(string $value): static
    {
        if (self::hasNot8Digits($value)) {
            throw new CardNumberNot8Digits();
        }

        return new static($value);
    }

    private static function hasNot16Digits(string $value): bool
    {
        return preg_match('/\d{16}/' , $value) === 0;
    }

    private static function hasNot8Digits(string $value): bool
    {
        return preg_match('/^\d{8}$/' , $value) === 0;
    }

    private static function validateNotEmpty(string $value): void
    {
        if (empty($value)) {
            throw new CardNumberEmpty();
        }
    }

    public function last8Digits(): string
    {
        return substr($this->value , -8);
    }
}