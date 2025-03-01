<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardOperationDescriptionPay extends StringValueObject
{
    public static function create(string $cardNumber , string $mainCard): static
    {
        $message = self::setMessage($cardNumber , $mainCard);
        return new static($message);
    }

    private static function setMessage(string $cardNumber , string $mainCard): string
    {
        return empty($mainCard) ? "Trasferencia a tarjeta $cardNumber" : "Trasferencia a cuenta global";
    }
}