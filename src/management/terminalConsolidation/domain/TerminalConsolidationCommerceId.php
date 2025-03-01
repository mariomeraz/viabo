<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\domain;

use Viabo\management\terminalConsolidation\domain\exceptions\TerminalConsolidationCommerceIdEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class TerminalConsolidationCommerceId extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new TerminalConsolidationCommerceIdEmpty();
        }
    }

}
