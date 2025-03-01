<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardMovementConcept extends StringValueObject
{
    public static function fromOperations(
        CardMovementSetTransactionId $transactionId ,
        array                        $operations
    ): static
    {
        foreach ($operations as $operation) {
            $payTransactionId = $operation['payTransactionId'];
            $reverseTransactionId = $operation['reverseTransactionId'];
            if ($transactionId->isSame($payTransactionId) || $transactionId->isSame($reverseTransactionId)) {
                $value = $operation['concept'];
            }
        }
        return new static($value ?? '');
    }

    public function update(string $value): static
    {
        return new static($value);
    }
}