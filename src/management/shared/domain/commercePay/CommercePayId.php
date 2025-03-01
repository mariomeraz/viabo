<?php declare(strict_types=1);

namespace Viabo\management\shared\domain\commercePay;

use Viabo\management\terminalTransaction\domain\exceptions\CommercePayIdEmpty;
use Viabo\shared\domain\valueObjects\UuidValueObject;

final class CommercePayId extends UuidValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CommercePayIdEmpty();
        }
    }
}
