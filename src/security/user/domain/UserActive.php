<?php declare(strict_types=1);


namespace Viabo\security\user\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class UserActive extends StringValueObject
{
    public static function enable(): static
    {
        return new static('1');
    }

    public function update(string $value): static
    {
        $value = empty($value) ? '0' : $value;
        return new static($value);
    }
}
