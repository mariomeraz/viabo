<?php

namespace Viabo\management\commerceTerminal\domain;

use Viabo\management\commerceTerminal\domain\exceptions\TerminalValueEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

class TerminalValueId extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new TerminalValueEmpty();
        }
    }
}
