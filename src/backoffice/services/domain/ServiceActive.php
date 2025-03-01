<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class ServiceActive extends StringValueObject
{
    public static function active(): static
    {
        return new static('1');
    }

    public function update(string $value): static
    {
        return new static($value);
    }
}