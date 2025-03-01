<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardOperationDescriptionReverse extends StringValueObject
{
    public function update(string $cardNumber , string $mainCard): static
    {
        $message = self::setMessage($cardNumber , $mainCard);
        return new static($message);
    }

    private static function setMessage(string $cardNumber , string $mainCard): string
    {
        return empty($mainCard) ? "Trasferencia desde la tarjeta $cardNumber" : "Trasferencia desde la cuenta global";
    }
}