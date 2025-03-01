<?php declare(strict_types=1);

namespace Viabo\backoffice\services\domain\new;

use Viabo\shared\domain\valueObjects\StringValueObject;

final class ServiceActive extends StringValueObject
{
    public static function active(): static
    {
        return new static('1');
    }

    public function value(): string
    {
        return empty($this->value) ? '0' : $this->value;
    }
}
