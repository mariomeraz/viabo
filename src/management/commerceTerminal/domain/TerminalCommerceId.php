<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\domain;

use Viabo\shared\domain\valueObjects\StringValueObject;
use Viabo\management\commerceTerminal\domain\exceptions\TerminalCommerceIdEmpty;

final class TerminalCommerceId extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new TerminalCommerceIdEmpty();
        }
    }
}
