<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\domain;

use Viabo\shared\domain\utils\DatePHP;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class TerminalConsolidationReferenceNumber extends StringValueObject
{
    public static function random(): static
    {
        $date = new DatePHP();
        $reference = $date->serializeDate();
        return new static($reference);
    }
}
