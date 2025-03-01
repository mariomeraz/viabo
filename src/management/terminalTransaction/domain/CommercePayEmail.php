<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\domain;

use Viabo\management\terminalTransaction\domain\exceptions\CommercePayEmailEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayEmail extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CommercePayEmailEmpty();
        }
    }
}
