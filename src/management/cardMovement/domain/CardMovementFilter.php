<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\management\shared\domain\card\CardClientKey;
use Viabo\management\shared\domain\card\CardNumber;

final class CardMovementFilter
{

    public function __construct(
        private CardNumber              $cardNumber ,
        private CardClientKey           $clientKey ,
        private CardMovementInitialDate $initialDate ,
        private CardMovementFinalDate   $finalDate
    )
    {
    }

    public static function empty(): static
    {
        return new static(
            new CardNumber('') ,
            new CardClientKey('') ,
            new CardMovementInitialDate('') ,
            new CardMovementFinalDate('') ,
        );
    }

    public static function create(
        string $cardNumber ,
        string $clientKey ,
        string $initialDate ,
        string $finalDate
    ): static
    {
        return new static(
            CardNumber::create($cardNumber) ,
            CardClientKey::create($clientKey) ,
            CardMovementInitialDate::create($initialDate) ,
            CardMovementFinalDate::create($finalDate)
        );
    }

    public function clientKey(): CardClientKey
    {
        return $this->clientKey;
    }

    public function cardNumber(): CardNumber
    {
        return $this->cardNumber;
    }

    public function initialDate(): CardMovementInitialDate
    {
        return $this->initialDate;
    }

    public function finalDate(): CardMovementFinalDate
    {
        return $this->finalDate;
    }

}