<?php declare(strict_types=1);


namespace Viabo\security\user\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserBusinessId extends StringValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }

    public static function empty(): static
    {
        return new static('');
    }

    public function isNotDefined(): bool
    {
        return empty($this->value);
    }

}