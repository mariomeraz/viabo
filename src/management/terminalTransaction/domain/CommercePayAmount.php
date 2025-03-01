<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\domain;

use Viabo\management\terminalTransaction\domain\exceptions\CommercePayAmountEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class CommercePayAmount extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        $value = number_format(floatval($value) , 2 , "." , "");
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new CommercePayAmountEmpty();
        }
    }
}
