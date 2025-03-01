<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardMovementDescription extends StringValueObject
{
    public static function fromOperations(
        mixed                        $value ,
        CardMovementSetTransactionId $transactionId ,
        array                        $operations
    ): static
    {
        foreach ($operations as $operation) {
            if ($transactionId->isSame($operation['payTransactionId'])) {
                return new static($operation['descriptionPay']);
            }

            if ($transactionId->isSame($operation['reverseTransactionId'])) {
                return new static($operation['descriptionReverse']);
            }
        }

        return new static(strval($value));
    }

    public static function empty(): static
    {
        return new static('');
    }

    public function update(mixed $value): static
    {
        return self::fromOperations($value);
    }
}