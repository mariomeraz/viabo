<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new\pay;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class PayServiceBranchOffices extends StringValueObject
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