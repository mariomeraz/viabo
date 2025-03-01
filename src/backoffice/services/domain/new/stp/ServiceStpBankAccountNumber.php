<?php declare(strict_types=1);

namespace Viabo\backoffice\services\domain\new\stp;

use Viabo\shared\domain\valueObjects\StringValueObject;

final class ServiceStpBankAccountNumber extends StringValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }
}
