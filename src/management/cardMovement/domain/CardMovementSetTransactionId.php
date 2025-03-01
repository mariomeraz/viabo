<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardMovementSetTransactionId extends StringValueObject
{
    public static function create(mixed $value): static
    {
        $value = strval($value);
        return new static($value);
    }

    public function isSame(mixed $operationId): bool
    {
        $operationId = strval($operationId);
        return str_contains($this->value , $operationId) && !empty($operationId);
    }
}
