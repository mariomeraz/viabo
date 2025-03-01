<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class DocumentAuthorizationValue extends StringValueObject
{
    public static function create(string $value): static
    {
        $value = empty($value) ? '0' : $value;
        return new static($value);
    }
}