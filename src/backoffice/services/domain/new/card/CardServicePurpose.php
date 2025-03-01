<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new\card;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardServicePurpose extends StringValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }

    public function update(string $value): static
    {
        return new static($value);
    }
}