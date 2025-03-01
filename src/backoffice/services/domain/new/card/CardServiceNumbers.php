<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new\card;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardServiceNumbers extends StringValueObject
{
    public static function create(string $value): static
    {
        $value = self::setValue($value);
        return new static($value);
    }

    public static function setValue(string $value): string
    {
        return empty($value) ? '0' : $value;
    }

    public function update(string $value): static
    {
        return self::create($value);
    }
}