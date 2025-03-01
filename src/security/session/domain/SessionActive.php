<?php declare(strict_types=1);


namespace Viabo\security\session\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class SessionActive extends StringValueObject
{
    public static function enable(): static
    {
        return new static('1');
    }

    public function update(string $value): static
    {
        return new static($value);
    }
}