<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardMovementOperationType extends StringValueObject
{

    public static function create(string $value): static
    {
        return new static($value);
    }

    public static function empty(): static
    {
        return new static('');
    }

    public static function fromOperations(
        array                        $operations ,
        CardMovementSetTransactionId $transactionId ,
        bool                         $isExpense): static
    {
        foreach ($operations as $operation) {
            if ($transactionId->isSame($operation['payTransactionId'])) {
                return new static("VIABO CARD");
            }

            if ($transactionId->isSame($operation['reverseTransactionId'])) {
                return new static("VIABO CARD");
            }
        }

        $value = $isExpense ? "OTROS CARGOS" : "SPEI";
        return new static($value);
    }

    public function isExternalCharges(): bool
    {
        return strtolower($this->value) === 'otros cargos';
    }
}