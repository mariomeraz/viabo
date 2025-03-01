<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\utils\DatePHP;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class TransactionReference extends StringValueObject
{
    public static function random(): static
    {
        $date = new DatePHP();
        $date = intval($date->serializeDate());
        return new static(strval($date));
    }

    public static function fromIncrement(string $value): self
    {
        $value = intval($value) + 1;
        return new self(strval($value));
    }

    public function increment(int $count): static
    {
        $value = intval($this->value) + $count;
        return new static(strval($value));
    }

}