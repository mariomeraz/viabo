<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class ServiceCreatedByUser extends StringValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }
}