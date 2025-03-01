<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\shared\domain\Collection;

final class CardMovements extends Collection
{
    public static function fromValues(array $values): static
    {
        return new static(array_map(self::cardMovementBuilder() , $values));
    }

    private static function cardMovementBuilder(): callable
    {
        return fn(array $values): CardMovement => CardMovement::fromValue($values);
    }

    public function movements(): array
    {
        return $this->items();
    }

    public function toArray(): array
    {
        return array_map(function (CardMovement $cardMovement) {
            return $cardMovement->toArray();
        } , $this->items());
    }

    public function addReceiptIdToMovements(string $receiptId): void
    {
        array_map(function (CardMovement $cardMovement) use ($receiptId) {
            $cardMovement->updateReceipt($receiptId);
        } , $this->items());
    }

    protected function type(): string
    {
        return CardMovement::class;
    }


}