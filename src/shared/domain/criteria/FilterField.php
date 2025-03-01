<?php declare(strict_types=1);


namespace Viabo\shared\domain\criteria;


use Viabo\shared\domain\criteria\exceptions\FilterFieldEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class FilterField extends StringValueObject
{
    public static function create($value): self
    {
        self::validate($value);
        return new self($value);
    }

    private static function validate(?string $value)
    {
        if (empty($value)) {
            throw new FilterFieldEmpty();
        }
    }
}