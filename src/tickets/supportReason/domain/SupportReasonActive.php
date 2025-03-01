<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class SupportReasonActive extends StringValueObject
{
    public static function enable(): static
    {
        return new static('1');
    }
}