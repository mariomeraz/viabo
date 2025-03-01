<?php declare(strict_types=1);

namespace Viabo\backoffice\services\domain\new\cardCloud;

use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardCloudSubAccount extends StringValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }
}
