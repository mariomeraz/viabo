<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\management\card\domain\exceptions\CardExpired;
use Viabo\management\card\domain\exceptions\CardExpirationDateEmpty;
use Viabo\shared\domain\utils\DatePHP;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardExpirationDate extends StringValueObject
{
    public static function create(string $value): static
    {
        static::validate($value);
        return new static($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value) || self::isNotFormat($value)) {
            throw new CardExpirationDateEmpty();
        }

        if (self::isExpired($value)) {
            throw new CardExpired();
        }
    }

    private static function isNotFormat(string $value): bool
    {
        return preg_match('/\d{2}\/\d{2}/' , $value) === 0;
    }

    private static function isExpired(string $value): bool
    {
        $date = new DatePHP();
        $now = $date->formatDateTime($date->now() , 'ym');
        $value = implode('' , array_reverse(explode('/' , $value)));
        return $value < $now;
    }

    public function month(): string
    {
        return explode('/' , $this->value)[0];
    }

    public function year(): string
    {
        return explode('/' , $this->value)[1];
    }

    public function isDifferent(string $value): bool
    {
        return $this->value !== $value;
    }
}